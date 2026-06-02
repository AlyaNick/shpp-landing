<script setup>
import { ref } from 'vue'
import DocModal from '../DocModal.vue'
import { siteConfig } from '../../data/siteConfig.js'

const show = ref(false)

const sections = [
  { id: 'policy-1', title: '1. Общие положения', nav: '1. Общие положения' },
  { id: 'policy-2', title: '2. Основные понятия', nav: '2. Основные понятия' },
  { id: 'policy-3', title: '3. Принципы обработки персональных данных', nav: '3. Принципы обработки' },
  { id: 'policy-4', title: '4. Цели обработки персональных данных', nav: '4. Цели обработки' },
  { id: 'policy-5', title: '5. Правовые основания обработки', nav: '5. Правовые основания' },
  { id: 'policy-6', title: '6. Объём и категории персональных данных', nav: '6. Объём и категории' },
  { id: 'policy-7', title: '7. Порядок обработки персональных данных', nav: '7. Порядок обработки' },
  { id: 'policy-8', title: '8. Права субъекта персональных данных', nav: '8. Права субъекта' },
  { id: 'policy-9', title: '9. Использование файлов cookie', nav: '9. Cookie' },
  { id: 'policy-10', title: '10. Заключительные положения', nav: '10. Заключительные положения' },
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
  <DocModal :show="show" title="Политика конфиденциальности" @close="close">
    <div class="doc-with-nav">
      <nav class="doc-nav" aria-label="Разделы документа">
        <a v-for="section in sections" :key="section.id" :href="`#${section.id}`">
          {{ section.nav }}
        </a>
      </nav>
      <div class="doc-content">
        <p class="doc-lead">
          Политика обработки персональных данных {{ siteConfig.operatorName }}.
        </p>
        <template v-for="section in sections" :key="section.id">
          <p class="doc-h" :id="section.id">{{ section.title }}</p>
          <p class="doc-placeholder">Текст раздела формируется и будет опубликован позднее.</p>
        </template>
      </div>
    </div>
  </DocModal>
</template>
