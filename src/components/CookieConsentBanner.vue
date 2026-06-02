<script setup>
import { ref, onMounted } from 'vue'
import CookiePolicyDocument from './documents/CookiePolicyDocument.vue'
import { images } from '../data/images.js'

const STORAGE_KEY = 'shpp_cookie_consent_v1'

const visible = ref(false)
const policyRef = ref(null)

onMounted(() => {
  try {
    visible.value = localStorage.getItem(STORAGE_KEY) !== '1'
  } catch {
    visible.value = true
  }
})

function accept() {
  try {
    localStorage.setItem(STORAGE_KEY, '1')
  } catch {
    /* ignore */
  }
  visible.value = false
}

function openPolicy() {
  policyRef.value?.open()
}
</script>

<template>
  <Teleport to="body">
    <CookiePolicyDocument ref="policyRef" />
    <Transition name="cookie-banner">
      <div v-if="visible" class="cookie-banner" role="banner" aria-label="Согласие на cookie">
        <div class="cookie-banner__inner">
          <div class="cookie-banner__art" aria-hidden="true">
            <img
              class="cookie-banner__image"
              :src="images.cookie.banner"
              alt=""
              width="88"
              height="72"
            />
          </div>

          <div class="cookie-banner__text">
            <p class="cookie-banner__title">Мы используем cookie</p>
            <p class="cookie-banner__desc">
              Продолжая пользоваться сайтом, вы соглашаетесь на обработку файлов cookie в соответствии с
              <button type="button" class="cookie-banner__link" @click="openPolicy">
                политикой обработки cookie
              </button>.
            </p>
          </div>

          <div class="cookie-banner__actions">
            <button type="button" class="cookie-banner__btn cookie-banner__btn--ghost" @click="openPolicy">
              Подробнее
            </button>
            <button type="button" class="cookie-banner__btn cookie-banner__btn--primary" @click="accept">
              Принять
            </button>
          </div>
        </div>
      </div>
    </Transition>
  </Teleport>
</template>

<style scoped>
.cookie-banner {
  position: fixed;
  left: 0;
  right: 0;
  bottom: 0;
  z-index: 1100;
  padding: 16px;
  padding-bottom: max(16px, env(safe-area-inset-bottom));
  pointer-events: none;
}

.cookie-banner__inner {
  pointer-events: auto;
  max-width: 960px;
  margin: 0 auto;
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  gap: 16px 20px;
  padding: 16px 20px;
  background: linear-gradient(135deg, rgba(7, 16, 15, 0.96) 0%, rgba(11, 29, 27, 0.94) 100%);
  border: 1px solid rgba(85, 216, 208, 0.22);
  border-radius: 12px;
  box-shadow: 0 -8px 40px rgba(0, 0, 0, 0.45);
  backdrop-filter: blur(12px);
}

.cookie-banner__art {
  flex-shrink: 0;
  width: 88px;
  height: 72px;
  display: grid;
  place-items: center;
}

.cookie-banner__image {
  width: 88px;
  height: auto;
  object-fit: contain;
  filter: drop-shadow(0 4px 12px rgba(85, 216, 208, 0.28));
}

.cookie-banner__text {
  flex: 1 min(100%, 420px);
  min-width: 0;
}

.cookie-banner__title {
  margin: 0 0 6px;
  font-size: 15px;
  font-weight: 800;
  color: #fff;
}

.cookie-banner__desc {
  margin: 0;
  font-size: 13px;
  line-height: 1.5;
  color: var(--muted);
}

.cookie-banner__link {
  display: inline;
  padding: 0;
  border: 0;
  background: none;
  color: var(--teal);
  font: inherit;
  text-decoration: underline;
  text-underline-offset: 2px;
  cursor: pointer;
}

.cookie-banner__link:hover {
  color: var(--teal-2);
}

.cookie-banner__actions {
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
  margin-left: auto;
}

.cookie-banner__btn {
  padding: 10px 18px;
  border-radius: 999px;
  font-size: 13px;
  font-weight: 700;
  cursor: pointer;
}

.cookie-banner__btn--ghost {
  border: 1px solid rgba(85, 216, 208, 0.35);
  background: transparent;
  color: #fff;
}

.cookie-banner__btn--ghost:hover {
  background: rgba(85, 216, 208, 0.08);
}

.cookie-banner__btn--primary {
  border: 0;
  color: #052321;
  background: linear-gradient(180deg, var(--teal-2), var(--teal));
}

.cookie-banner__btn--primary:hover {
  filter: brightness(1.05);
}

.cookie-banner-enter-active,
.cookie-banner-leave-active {
  transition: opacity 0.45s ease, transform 0.45s ease;
}

.cookie-banner-enter-from,
.cookie-banner-leave-to {
  opacity: 0;
  transform: translateY(12px);
}

@media (max-width: 640px) {
  .cookie-banner__inner {
    flex-direction: column;
    align-items: stretch;
  }

  .cookie-banner__art {
    margin: 0 auto;
  }

  .cookie-banner__actions {
    margin-left: 0;
  }

  .cookie-banner__btn {
    flex: 1;
    text-align: center;
  }
}
</style>
