<script setup>
import { ref } from 'vue'

defineProps({
  show: Boolean,
  title: String,
})

const emit = defineEmits(['close'])

const bodyRef = ref(null)

function onOverlayClick(event) {
  if (event.target.classList.contains('doc-modal__backdrop')) {
    emit('close')
  }
}

function onBodyClick(event) {
  const link = event.target.closest('a[href^="#"]')
  if (!link || (link.getAttribute('href') ?? '') === '#') {
    return
  }
  event.preventDefault()
  const id = link.getAttribute('href')?.slice(1)
  if (!id) {
    return
  }
  bodyRef.value?.querySelector(`#${id}`)?.scrollIntoView({ behavior: 'smooth', block: 'start' })
}
</script>

<template>
  <Teleport to="body">
    <Transition name="doc-modal">
      <div
        v-if="show"
        class="doc-modal__backdrop"
        role="dialog"
        aria-modal="true"
        :aria-label="title"
        @click="onOverlayClick"
      >
        <div class="doc-modal__box">
          <div class="doc-modal__header">
            <h3 class="doc-modal__title">{{ title }}</h3>
            <button type="button" class="doc-modal__close" aria-label="Закрыть" @click="emit('close')">
              ×
            </button>
          </div>
          <div ref="bodyRef" class="doc-modal__body" @click="onBodyClick">
            <slot />
          </div>
        </div>
      </div>
    </Transition>
  </Teleport>
</template>

<style scoped>
.doc-modal__backdrop {
  position: fixed;
  inset: 0;
  z-index: 2000;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 24px;
  background: rgba(0, 0, 0, 0.78);
  backdrop-filter: blur(6px);
}

.doc-modal__box {
  width: 100%;
  max-width: 960px;
  max-height: 85vh;
  display: flex;
  flex-direction: column;
  background: #0b1413;
  border: 1px solid rgba(85, 216, 208, 0.22);
  border-radius: 12px;
  box-shadow: 0 24px 48px rgba(0, 0, 0, 0.55);
  overflow: hidden;
}

.doc-modal__header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 16px;
  padding: 18px 22px;
  border-bottom: 1px solid rgba(255, 255, 255, 0.08);
  flex-shrink: 0;
}

.doc-modal__title {
  margin: 0;
  font-size: 18px;
  font-weight: 800;
  color: #fff;
}

.doc-modal__close {
  width: 36px;
  height: 36px;
  display: grid;
  place-items: center;
  padding: 0;
  border: 0;
  border-radius: 8px;
  background: rgba(85, 216, 208, 0.1);
  color: var(--teal);
  font-size: 24px;
  line-height: 1;
  cursor: pointer;
}

.doc-modal__close:hover {
  background: rgba(85, 216, 208, 0.18);
}

.doc-modal__body {
  padding: 22px;
  overflow-y: auto;
  font-size: 14px;
  line-height: 1.6;
  color: var(--muted);
}

.doc-modal__body :deep(.doc-with-nav) {
  display: flex;
  gap: 24px;
  align-items: flex-start;
}

.doc-modal__body :deep(.doc-nav) {
  flex-shrink: 0;
  width: 200px;
  position: sticky;
  top: 0;
  display: flex;
  flex-direction: column;
  gap: 8px;
  padding-right: 16px;
  border-right: 1px solid rgba(255, 255, 255, 0.08);
}

.doc-modal__body :deep(.doc-nav a) {
  font-size: 13px;
  color: var(--muted-2);
  text-decoration: none;
  line-height: 1.35;
}

.doc-modal__body :deep(.doc-nav a:hover) {
  color: var(--teal);
}

.doc-modal__body :deep(.doc-content) {
  flex: 1;
  min-width: 0;
}

.doc-modal__body :deep(.doc-h) {
  margin: 20px 0 8px;
  font-size: 16px;
  font-weight: 800;
  color: #fff;
  scroll-margin-top: 8px;
}

.doc-modal__body :deep(.doc-content .doc-h:first-child) {
  margin-top: 0;
}

.doc-modal__body :deep(.doc-placeholder) {
  margin: 0 0 12px;
  color: var(--muted);
}

.doc-modal__body :deep(.doc-lead) {
  margin: 0 0 16px;
  color: var(--muted-2);
}

.doc-modal-enter-active,
.doc-modal-leave-active {
  transition: opacity 0.25s ease;
}

.doc-modal-enter-from,
.doc-modal-leave-to {
  opacity: 0;
}

.doc-modal-enter-active .doc-modal__box,
.doc-modal-leave-active .doc-modal__box {
  transition: transform 0.25s ease;
}

.doc-modal-enter-from .doc-modal__box,
.doc-modal-leave-to .doc-modal__box {
  transform: scale(0.96);
}

@media (max-width: 768px) {
  .doc-modal__body :deep(.doc-nav) {
    display: none;
  }

  .doc-modal__body :deep(.doc-with-nav) {
    display: block;
  }
}
</style>
