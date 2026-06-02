import { execSync, spawn } from 'node:child_process'
import { existsSync, readdirSync } from 'node:fs'
import path from 'node:path'
import { fileURLToPath } from 'node:url'

const root = path.join(fileURLToPath(new URL('.', import.meta.url)), '..')
const publicDir = path.join(root, 'public')

function scanPhpInDir(dir) {
  if (!existsSync(dir)) {
    return null
  }

  for (const entry of readdirSync(dir, { withFileTypes: true })) {
    if (entry.isDirectory()) {
      const nested = path.join(dir, entry.name, 'php.exe')
      if (existsSync(nested)) {
        return nested
      }
    }
  }

  const direct = path.join(dir, 'php.exe')
  return existsSync(direct) ? direct : null
}

function resolvePhp() {
  if (process.env.PHP_PATH && existsSync(process.env.PHP_PATH)) {
    return process.env.PHP_PATH
  }

  try {
    const output = execSync('where php', {
      encoding: 'utf8',
      stdio: ['ignore', 'pipe', 'ignore'],
    })
    const first = output.trim().split(/\r?\n/).find(Boolean)
    if (first && existsSync(first)) {
      return first
    }
  } catch {
    // php not in PATH
  }

  const commonRoots = [
    'C:\\OpenServer\\modules\\php',
    'C:\\OSPanel\\modules\\php',
    'C:\\laragon\\bin\\php',
    'C:\\xampp\\php',
    'C:\\php',
  ]

  for (const dir of commonRoots) {
    const found = scanPhpInDir(dir)
    if (found) {
      return found
    }
  }

  return null
}

const php = resolvePhp()

if (!php) {
  console.error('')
  console.error('PHP не найден.')
  console.error('  • Для вёрстки: npm run dev')
  console.error('  • С формой:    npm run dev:full (нужен PHP)')
  console.error('  • Или задайте PHP_PATH в .env, например:')
  console.error('    PHP_PATH=C:\\OpenServer\\modules\\php\\PHP_8.3\\php.exe')
  console.error('')
  process.exit(1)
}

console.log(`PHP: ${php}`)
console.log('API: http://127.0.0.1:8080/api/register.php')

const child = spawn(php, ['-S', '127.0.0.1:8080', '-t', publicDir], {
  cwd: root,
  stdio: 'inherit',
})

child.on('exit', (code) => process.exit(code ?? 0))

process.on('SIGINT', () => child.kill('SIGINT'))
process.on('SIGTERM', () => child.kill('SIGTERM'))
