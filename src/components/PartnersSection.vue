<template>
  <section id="partners" class="panel section partners-section">
    <div class="section-head">
      <h2>Партнёры</h2>
      <span></span>
    </div>

    <ul class="partners-list">
      <li v-for="logo in partners" :key="logo.src" :class="logo.className">
        <img :src="logo.src" alt="" />
      </li>
    </ul>
  </section>
</template>

<script setup>
import { images } from '../data/images.js'

const partners = [
  { src: images.partners.gis, className: 'partners-item--white' },
  { src: images.partners.novyeLyudi, className: 'partners-item--white' },
  { src: images.partners.arkonaForest, className: 'partners-item--light' },
]
</script>
