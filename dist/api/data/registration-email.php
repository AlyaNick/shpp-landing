<?php

declare(strict_types=1);

function renderRegistrationEmail(array $fields): string
{
    $name = htmlspecialchars($fields['name'], ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars($fields['email'], ENT_QUOTES, 'UTF-8');
    $sphere = htmlspecialchars($fields['sphere'] ?: '—', ENT_QUOTES, 'UTF-8');
    $request = nl2br(htmlspecialchars($fields['request'] ?: '—', ENT_QUOTES, 'UTF-8'));
    $date = htmlspecialchars($fields['date'], ENT_QUOTES, 'UTF-8');

    return <<<HTML
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Новая заявка в ШПП</title>
</head>
<body style="margin:0;padding:0;background:#07100f;font-family:Arial,sans-serif;color:#ffffff;">
  <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#07100f;padding:24px 0;">
    <tr>
      <td align="center">
        <table role="presentation" width="600" cellspacing="0" cellpadding="0" style="max-width:600px;width:100%;background:#0b1d1b;border:1px solid rgba(85,216,208,0.28);border-radius:12px;overflow:hidden;">
          <tr>
            <td style="padding:28px 32px;background:linear-gradient(180deg,#0f3c38,#0b211f);">
              <div style="font-size:12px;font-weight:700;letter-spacing:0.18em;text-transform:uppercase;color:#55d8d0;">ШПП</div>
              <h1 style="margin:12px 0 0;font-size:28px;line-height:1.1;color:#ffffff;">Новая заявка на регистрацию</h1>
            </td>
          </tr>
          <tr>
            <td style="padding:28px 32px;">
              <table role="presentation" width="100%" cellspacing="0" cellpadding="0">
                <tr>
                  <td style="padding:0 0 14px;color:#b8c1c0;font-size:14px;width:180px;vertical-align:top;">Имя</td>
                  <td style="padding:0 0 14px;color:#ffffff;font-size:16px;font-weight:600;">{$name}</td>
                </tr>
                <tr>
                  <td style="padding:0 0 14px;color:#b8c1c0;font-size:14px;vertical-align:top;">Email</td>
                  <td style="padding:0 0 14px;color:#ffffff;font-size:16px;"><a href="mailto:{$email}" style="color:#55d8d0;text-decoration:none;">{$email}</a></td>
                </tr>
                <tr>
                  <td style="padding:0 0 14px;color:#b8c1c0;font-size:14px;vertical-align:top;">Сфера деятельности</td>
                  <td style="padding:0 0 14px;color:#ffffff;font-size:16px;">{$sphere}</td>
                </tr>
                <tr>
                  <td style="padding:0 0 14px;color:#b8c1c0;font-size:14px;vertical-align:top;">Запрос</td>
                  <td style="padding:0 0 14px;color:#ffffff;font-size:16px;line-height:1.5;">{$request}</td>
                </tr>
                <tr>
                  <td style="padding:0;color:#788684;font-size:13px;vertical-align:top;">Дата</td>
                  <td style="padding:0;color:#788684;font-size:13px;">{$date}</td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>
HTML;
}
