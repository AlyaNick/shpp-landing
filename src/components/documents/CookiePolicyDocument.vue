<script setup lang="ts">
import { ref } from 'vue'
import DocModal from '../DocModal.vue'

import { siteConfig } from '../../data/siteConfig.js'

const show = ref(false)
function open() {
  show.value = true
}
function close() {
  show.value = false
}
defineExpose({ open })
</script>

<template>
  <DocModal :show="show" title="Политика обработки файлов cookie" @close="close">
    <div class="cookie-doc">
      <p class="cookie-doc__lead">
        Настоящий документ описывает использование файлов cookie на сайте {{ siteConfig.operatorName }}.
      </p>
      <p class="cookie-doc__h" id="cookie-1">1. Что такое cookie</p>
      <p>
        Cookie — небольшие текстовые файлы, которые сайт сохраняет на устройстве пользователя. Они помогают
        корректно отображать страницы, запоминать настройки и улучшать работу сайта.
      </p>
      <p class="cookie-doc__h" id="cookie-2">2. Какие cookie мы используем</p>
      <p>
        Мы можем использовать технические cookie, необходимые для работы сайта (например, запоминание согласия
        на обработку cookie), а также cookie для аналитики и улучшения работы сервиса — только после вашего
        согласия, где это требуется законом.
      </p>
      <p class="cookie-doc__h" id="cookie-3">3. Отключение cookie</p>
      <p>
        Вы можете отключить или удалить cookie в настройках браузера. Обратите внимание: часть функций сайта
        может работать некорректно без cookie.
      </p>
      <p class="cookie-doc__h" id="cookie-4">4. Контакты</p>
      <p>
        По вопросам обработки cookie можно обратиться к Оператору: {{ siteConfig.operatorEmail }}.
      </p>
    </div>
  </DocModal>
</template>

<style scoped>
.cookie-doc__h {
  margin: 1.25rem 0 0.5rem;
  font-weight: 700;
  font-size: 1rem;
}
</style>