<script setup>
import { inject } from 'vue'
import { images } from '../data/images.js'

const openDocument = inject('openDocument', null)
</script>

<template>
  <footer id="contacts" class="footer panel">
    <div class="footer__inner">
      <div class="footer-row footer-row--top">
        <div class="footer-brand-line">
          <a href="#top" class="brand">ШПП</a>
          <span class="footer-brand-text">— Штаб поддержки предпринимателей</span>
        </div>
        <button type="button" class="footer-privacy" @click="openDocument?.('policy')">
          Политика конфиденциальности
        </button>
      </div>

      <div class="footer-row footer-row--bottom">
        <a href="mailto:info@shpp.ru" class="footer-contact">info@shpp.ru</a>
        <div class="footer-bottom-right">
          <a href="tel:+78001234567" class="footer-contact">8 800 123-45-67</a>
          <div class="footer-social">
            <a href="#" class="footer-social-link" aria-label="Telegram">
              <img :src="images.social.telegram" alt="" width="14" height="14" />
            </a>
            <a href="#" class="footer-social-link" aria-label="VK">
              <img :src="images.social.vk" alt="" width="14" height="14" />
            </a>
          </div>
        </div>
      </div>
    </div>
  </footer>
</template>
