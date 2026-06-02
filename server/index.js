import path from 'node:path'
import { fileURLToPath } from 'node:url'
import fs from 'node:fs'

import dotenv from 'dotenv'
import express from 'express'
import nodemailer from 'nodemailer'

import { buildRegistrationEmailHtml } from './emailTemplate.js'

dotenv.config({ path: path.resolve(process.cwd(), '.env') })

const __dirname = path.dirname(fileURLToPath(import.meta.url))
const distPath = path.resolve(__dirname, '..', 'dist')

const port = Number(process.env.PORT || 3001)
const operatorEmail = (process.env.OPERATOR_EMAIL || '').trim()
const yandexAppPassword = (process.env.YANDEX_APP_PASSWORD || '').trim()
const smtpHost = (process.env.SMTP_HOST || 'smtp.yandex.ru').trim()
const smtpPort = Number(process.env.SMTP_PORT || 465)

const app = express()
app.use(express.json())

app.post('/api/register.php', async (req, res) => {
  if (!operatorEmail || !yandexAppPassword) {
    return res.status(500).json({
      error: 'Не заданы OPERATOR_EMAIL и YANDEX_APP_PASSWORD в .env',
    })
  }

  const name = String(req.body?.name ?? '').trim()
  const email = String(req.body?.email ?? '').trim()
  const sphere = String(req.body?.sphere ?? '').trim()
  const request = String(req.body?.request ?? '').trim()

  if (!name || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
    return res.status(400).json({
      error: 'Заполните имя и корректный email',
    })
  }

  const transporter = nodemailer.createTransport({
    host: smtpHost,
    port: smtpPort,
    secure: smtpPort === 465,
    auth: { user: operatorEmail, pass: yandexAppPassword },
  })

  try {
    await transporter.sendMail({
      from: `"ШПП" <${operatorEmail}>`,
      to: operatorEmail,
      replyTo: email,
      subject: `Новая заявка в ШПП — ${name}`,
      html: buildRegistrationEmailHtml({
        name,
        email,
        sphere: sphere || '—',
        request: request || '—',
      }),
    })

    return res.json({ ok: true })
  } catch (error) {
    console.error(error)
    return res.status(500).json({
      error: 'Не удалось отправить письмо. Проверьте настройки Яндекс.Почты.',
      detail: error?.message || String(error),
    })
  }
})

if (fs.existsSync(distPath)) {
  app.use(express.static(distPath))
  app.get('*', (req, res) => {
    if (req.path.startsWith('/api')) {
      return res.status(404).end()
    }
    res.sendFile(path.join(distPath, 'index.html'))
  })
}

const server = app.listen(port, '127.0.0.1', () => {
  console.log(`Mail API: http://127.0.0.1:${port}/api/register.php`)
})

server.on('error', (error) => {
  if (error.code === 'EADDRINUSE') {
    console.error(`Порт ${port} уже занят. Закройте предыдущий npm run dev или задайте другой PORT в .env`)
    process.exit(1)
  }

  console.error(error)
  process.exit(1)
})
