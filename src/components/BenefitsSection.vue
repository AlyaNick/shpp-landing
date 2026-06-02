<template>
  <section id="benefits" class="panel section benefits-section">
    <div class="benefits-copy">
      <div class="section-head">
        <h2>Что вы получите после регистрации</h2>
      </div>
      <ul class="benefits-list">
        <li v-for="item in benefits" :key="item">
          <span class="check">✓</span>
          {{ item }}
        </li>
      </ul>
    </div>
  </section>
</template>

<script setup>
import { benefits } from '../data/siteContent.js'
</script>