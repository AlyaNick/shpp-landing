<template>
  <section class="hero panel">
    <div class="hero-copy">
      <h1>Штаб поддержки предпринимателей</h1>
      <p class="hero-subtitle">Поддержка для тех, кто запускает или развивает бизнес</p>
      <p class="hero-text">
        Зарегистрируйтесь в ШПП, чтобы получать информацию о консультациях,
        мероприятиях, мерах поддержки и возможностях для предпринимателей.
      </p>
      <div class="hero-actions">
        <a class="primary-btn" href="#register">Зарегистрироваться</a>
        <span>Бесплатно. Без обязательств. Только полезная информация по вашему запросу.</span>
      </div>
    </div>

    <div class="hero-art" aria-hidden="true">
      <img class="hero-door" :src="images.hero.door" alt="Точка входа" />
      <img class="hero-chart" :src="images.hero.chart" alt="" />
      <img class="hero-ideas" :src="images.hero.ideas" alt="Идеи и рост бизнеса" />
    </div>
  </section>
</template>

<script setup>
import { images } from '../data/images.js'
</script>