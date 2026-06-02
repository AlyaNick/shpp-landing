<?php

declare(strict_types=1);

/**
 * Читает ответ SMTP до конца многострочной последовательности (RFC 5321).
 */
function smtp_read_response($sock): string
{
    $buffer = '';
    $max = 64;
    while (--$max > 0) {
        $line = fgets($sock, 8192);
        if ($line === false) {
            break;
        }
        $buffer .= $line;
        if (strlen($line) >= 4 && $line[3] === ' ') {
            break;
        }
    }

    return $buffer;
}

function smtp_connect_ssl(string $host, int $port): array
{
    $ctx = stream_context_create([
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
        ],
    ]);

    $sock = @stream_socket_client(
        "ssl://$host:$port",
        $errno,
        $errstr,
        30,
        STREAM_CLIENT_CONNECT,
        $ctx
    );

    if ($sock) {
        stream_set_timeout($sock, 30);
    }

    return [$sock, $errno, $errstr];
}

function smtp_auth_plain($sock, string $user, string $pass)
{
    $plain = base64_encode("\0" . $user . "\0" . $pass);
    fputs($sock, 'AUTH PLAIN ' . $plain . "\r\n");
    $authLine = trim(smtp_read_response($sock));
    $code = strlen($authLine) >= 3 ? substr($authLine, 0, 3) : '';

    return $code === '235' ? true : $authLine;
}

function smtp_auth_login($sock, string $user, string $pass)
{
    fputs($sock, "AUTH LOGIN\r\n");
    smtp_read_response($sock);
    fputs($sock, base64_encode($user) . "\r\n");
    smtp_read_response($sock);
    fputs($sock, base64_encode($pass) . "\r\n");
    $authLine = trim(smtp_read_response($sock));
    $code = strlen($authLine) >= 3 ? substr($authLine, 0, 3) : '';

    return $code === '235' ? true : $authLine;
}

function smtpSend(
    string $host,
    int $port,
    string $user,
    string $pass,
    string $from,
    string $to,
    string $subject,
    string $htmlBody,
    string $fromName = 'ШПП',
    ?string $replyTo = null
) {
    [$sock, $errno, $errstr] = smtp_connect_ssl($host, $port);
    if (!$sock) {
        return "Connection failed: $errstr ($errno)";
    }

    $greet = smtp_read_response($sock);
    if (!preg_match('/^220/m', trim($greet))) {
        fclose($sock);

        return 'Bad greeting: ' . trim($greet);
    }

    $ehloHost = preg_replace('/[^\w.-]+/', '', (string) gethostname()) ?: 'localhost';
    fputs($sock, "EHLO $ehloHost\r\n");
    smtp_read_response($sock);

    $authOk = smtp_auth_plain($sock, $user, $pass);
    if ($authOk !== true) {
        $plainErr = $authOk;
        fclose($sock);

        [$sock2, $errno2, $errstr2] = smtp_connect_ssl($host, $port);
        if (!$sock2) {
            return "Connection failed (retry): $errstr2 ($errno2)";
        }
        smtp_read_response($sock2);
        fputs($sock2, "EHLO $ehloHost\r\n");
        smtp_read_response($sock2);

        $authOk2 = smtp_auth_login($sock2, $user, $pass);
        if ($authOk2 !== true) {
            fclose($sock2);

            return 'Auth failed: ' . $authOk2 . ' (PLAIN: ' . $plainErr . ')';
        }
        $sock = $sock2;
    }

    fputs($sock, "MAIL FROM:<$from>\r\n");
    smtp_read_response($sock);

    fputs($sock, "RCPT TO:<$to>\r\n");
    smtp_read_response($sock);

    fputs($sock, "DATA\r\n");
    smtp_read_response($sock);

    $replyTo = $replyTo ?: $from;

    $msg = 'From: =?UTF-8?B?' . base64_encode($fromName) . "?= <$from>\r\n";
    $msg .= "To: <$to>\r\n";
    $msg .= "Reply-To: <$replyTo>\r\n";
    $msg .= 'Subject: =?UTF-8?B?' . base64_encode($subject) . "?=\r\n";
    $msg .= "MIME-Version: 1.0\r\n";
    $msg .= "Content-Type: text/html; charset=UTF-8\r\n";
    $msg .= "Content-Transfer-Encoding: base64\r\n";
    $msg .= "\r\n";
    $msg .= chunk_split(base64_encode($htmlBody));
    $msg .= "\r\n.\r\n";

    fputs($sock, $msg);
    $resp = trim(smtp_read_response($sock));

    fputs($sock, "QUIT\r\n");
    fclose($sock);

    return (strlen($resp) >= 3 && substr($resp, 0, 3) === '250') ? true : 'Send failed: ' . $resp;
}
