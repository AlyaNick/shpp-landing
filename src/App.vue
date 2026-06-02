<script setup>
import { provide, ref } from 'vue'
import SiteHeader from './components/SiteHeader.vue'
import HeroSection from './components/HeroSection.vue'
import AboutSection from './components/AboutSection.vue'
import BenefitsSection from './components/BenefitsSection.vue'
import StepsSection from './components/StepsSection.vue'
import RegisterSection from './components/RegisterSection.vue'
import SiteFooter from './components/SiteFooter.vue'
import CookieConsentBanner from './components/CookieConsentBanner.vue'
import DocumentModals from './components/DocumentModals.vue'

const documentModalsRef = ref(null)

function openDocument(doc) {
  documentModalsRef.value?.open(doc)
}

provide('openDocument', openDocument)
</script>

<template>
  <SiteHeader />

  <div class="page-shell">
    <main id="top">
      <HeroSection />
      <AboutSection />
      <BenefitsSection />
      <StepsSection />
      <RegisterSection />
    </main>
  </div>

  <SiteFooter />
  <DocumentModals ref="documentModalsRef" />
  <CookieConsentBanner />
</template>
