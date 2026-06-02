<script setup>
import { ref } from 'vue'
import DocModal from '../DocModal.vue'
import { siteConfig } from '../../data/siteConfig.js'

const show = ref(false)

const sections = [
  { id: 'consent-1', title: '1. Субъект персональных данных' },
  { id: 'consent-2', title: '2. Оператор персональных данных' },
  { id: 'consent-3', title: '3. Перечень персональных данных' },
  { id: 'consent-4', title: '4. Цели обработки' },
  { id: 'consent-5', title: '5. Способы обработки и срок хранения' },
  { id: 'consent-6', title: '6. Права субъекта и отзыв согласия' },
]

function open() {
  show.value = true
}

function close() {
  show.value = false
}

defineExpose({ open })
</script>

<template>
  <DocModal :show="show" title="Согласие на обработку персональных данных" @close="close">
    <div class="doc-with-nav">
      <nav class="doc-nav" aria-label="Разделы документа">
        <a v-for="section in sections" :key="section.id" :href="`#${section.id}`">
          {{ section.title }}
        </a>
      </nav>
      <div class="doc-content">
        <p class="doc-lead">
          Согласие на обработку персональных данных при использовании сайта {{ siteConfig.operatorName }}.
        </p>
        <template v-for="section in sections" :key="section.id">
          <p class="doc-h" :id="section.id">{{ section.title }}</p>
          <p class="doc-placeholder">Текст раздела формируется и будет опубликован позднее.</p>
        </template>
        <p class="doc-placeholder">
          Контакт для обращений: {{ siteConfig.operatorEmail }}.
        </p>
      </div>
    </div>
  </DocModal>
</template>
