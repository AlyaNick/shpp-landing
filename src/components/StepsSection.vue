<template>
  <section class="panel section how-section">
    <div class="section-head how-head">
      <h2>Как это работает</h2>
      <span></span>
    </div>
    <div class="steps-grid">
      <template v-for="(step, index) in steps" :key="step.number">
        <article class="step-card">
          <div class="step-art">
            <img :src="step.image" :alt="step.title" />
          </div>
          <h3><b>{{ index + 1 }}.</b> {{ step.title }}</h3>
          <p>{{ step.text }}</p>
        </article>
        <div v-if="index < steps.length - 1" class="step-arrow" aria-hidden="true"></div>
      </template>
    </div>
  </section>
</template>

<script setup>
import { steps } from '../data/siteContent.js'
</script>