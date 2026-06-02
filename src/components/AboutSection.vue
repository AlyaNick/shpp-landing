<template>
  <section id="about" class="panel section">
    <div class="section-head">
      <h2>Что такое ШПП</h2>
      <span></span>
    </div>
    <p class="lead">
      Штаб поддержки предпринимателей — это точка входа для предпринимателей,
      самозанятых и тех, кто планирует открыть своё дело.
      Через ШПП можно узнать
      о консультациях, обучающих мероприятиях, программах поддержки и возможностях для бизнеса.
    </p>

    <div class="audience-grid">
      <article v-for="item in audience" :key="item.title" class="audience-card">
        <img class="card-image" :src="item.image" :alt="item.title" />
        <h3>{{ item.title }}</h3>
        <p>{{ item.text }}</p>
      </article>
    </div>
  </section>
</template>

<script setup>
import { audience } from '../data/siteContent.js'
</script>