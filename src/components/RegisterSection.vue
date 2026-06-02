<script setup>
import { inject, ref } from 'vue'

const openDocument = inject('openDocument', null)

const submitted = ref(false)
const submitting = ref(false)
const error = ref('')
const form = ref({
  name: '',
  email: '',
  sphere: '',
  request: '',
})

async function submitForm() {
  if (!form.value.name.trim() || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(form.value.email.trim())) {
    return
  }

  submitting.value = true
  error.value = ''

  try {
    const response = await fetch('/api/register.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        name: form.value.name.trim(),
        email: form.value.email.trim(),
        sphere: form.value.sphere,
        request: form.value.request.trim(),
      }),
    })

    const data = await response.json()

    if (!response.ok || !data.ok) {
      throw new Error(data.error || data.detail || 'Не удалось отправить заявку')
    }

    submitted.value = true
  } catch (err) {
    error.value = err instanceof Error ? err.message : 'Не удалось отправить заявку'
  } finally {
    submitting.value = false
  }
}
</script>

<template>
  <section id="register" class="panel section register-section">
    <div class="form-side">
      <h2>Регистрация</h2>
      <p class="form-subtitle">Оставьте заявку в ШПП</p>
      <p class="form-hint">
        Заполните короткую форму, чтобы получать актуальную информацию для предпринимателей.
      </p>

      <form v-if="!submitted" class="form" @submit.prevent="submitForm">
        <input id="register-name" v-model="form.name" type="text" placeholder="Имя" required />
        <input v-model="form.email" type="email" placeholder="Email" required />
        <select v-model="form.sphere">
          <option value="">Сфера деятельности</option>
          <option>Только запускаюсь</option>
          <option>Уже есть бизнес</option>
          <option>Самозанятость</option>
          <option>Другое</option>
        </select>
        <textarea v-model="form.request" rows="4" placeholder="Ваш запрос"></textarea>
        <p class="form-consents">
          Отправляя форму, вы соглашаетесь с
          <button type="button" class="form-link" @click="openDocument?.('consent')">согласием</button>
          на обработку персональных данных и
          <button type="button" class="form-link" @click="openDocument?.('policy')">политикой конфиденциальности</button>.
        </p>
        <p v-if="error" class="form-error">{{ error }}</p>
        <button class="primary-btn full" type="submit" :disabled="submitting">
          {{ submitting ? 'Отправка...' : 'Регистрация' }}
        </button>
      </form>

      <div v-else class="success">
        <span>✓</span>
        <h3>Заявка отправлена</h3>
        <p>Спасибо! Мы свяжемся с вами и будем присылать полезную информацию.</p>
      </div>
    </div>

    <div class="final-side">
      <article class="final-card">
        <h3>Будьте в курсе возможностей для бизнеса</h3>
        <p>
          Зарегистрируйтесь в ШПП и получайте информацию о поддержке, мероприятиях
          и консультациях для предпринимателей.
        </p>
      </article>
    </div>
  </section>
</template>
