<script setup>
import { inject } from 'vue'
import { siteConfig } from '../data/siteConfig.js'

const openDocument = inject('openDocument', null)

const currentYear = new Date().getFullYear()
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
        <div>
          <p>{{ currentYear }} {{ siteConfig.operatorName }}. Все права защищены.</p>
          <p  class="footer-brand-text">
            ИНН {{ siteConfig.operatorInn }} &middot; ОГРН {{ siteConfig.operatorOgrn }} &middot;
            {{ siteConfig.operatorAddress }}
          </p>
          <a :href="`mailto:${ siteConfig.operatorEmail }`" class="footer-contact">{{ siteConfig.operatorEmail }}</a>
        </div>

        <div class="footer-bottom-right">

        </div>
      </div>
    </div>
  </footer>
</template>
