<script setup>
import { ref } from 'vue'
import DocModal from '../DocModal.vue'
import { siteConfig } from '../../data/siteConfig.js'

const show = ref(false)

const sections = [
  { id: 'cookie-1', title: '1. Что такое cookie' },
  { id: 'cookie-2', title: '2. Какие cookie мы используем' },
  { id: 'cookie-3', title: '3. Срок хранения cookie' },
  { id: 'cookie-4', title: '4. Отключение cookie' },
  { id: 'cookie-5', title: '5. Контакты оператора' },
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
  <DocModal :show="show" title="Политика обработки файлов cookie" @close="close">
    <div class="doc-with-nav">
      <nav class="doc-nav" aria-label="Разделы документа">
        <a v-for="section in sections" :key="section.id" :href="`#${section.id}`">
          {{ section.title }}
        </a>
      </nav>
      <div class="doc-content">
        <p class="doc-lead">
          Настоящий документ описывает использование файлов cookie на сайте {{ siteConfig.operatorName }}.
        </p>
        <template v-for="section in sections" :key="section.id">
          <p class="doc-h" :id="section.id">{{ section.title }}</p>
          <p class="doc-placeholder">Текст раздела формируется и будет опубликован позднее.</p>
        </template>
        <p class="doc-placeholder">
          По вопросам обработки cookie: {{ siteConfig.operatorEmail }}.
        </p>
      </div>
    </div>
  </DocModal>
</template>
