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
      <div
        v-for="figure in figures"
        :key="figure.id"
        class="hero-figure"
        :class="`hero-figure--${figure.id}`"
        :style="figureStyle(figure.id)"
        @mousemove="onFigureMove(figure.id, $event)"
        @mouseleave="onFigureLeave(figure.id)"
      >
        <div class="hero-figure__float">
          <img :class="`hero-${figure.id}`" :src="figure.src" :alt="figure.alt" />
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { reactive } from 'vue'
import { images } from '../data/images.js'

const figures = [
  { id: 'door', src: images.hero.door, alt: 'Точка входа', strength: 16 },
  { id: 'chart', src: images.hero.chart, alt: '', strength: 12 },
  { id: 'ideas', src: images.hero.ideas, alt: 'Идеи и рост бизнеса', strength: 16 },
]

const strengths = Object.fromEntries(figures.map((f) => [f.id, f.strength]))

const figurePointer = reactive({
  door: { x: 0, y: 0 },
  chart: { x: 0, y: 0 },
  ideas: { x: 0, y: 0 },
})

function onFigureMove(id, event) {
  const el = event.currentTarget
  const rect = el.getBoundingClientRect()
  if (!rect.width || !rect.height) return

  figurePointer[id] = {
    x: (event.clientX - rect.left) / rect.width - 0.5,
    y: (event.clientY - rect.top) / rect.height - 0.5,
  }
}

function onFigureLeave(id) {
  figurePointer[id] = { x: 0, y: 0 }
}

function figureStyle(id) {
  const pointer = figurePointer[id]
  const strength = strengths[id]
  const shiftX = pointer.x * strength
  const shiftY = pointer.y * (strength * 0.75)

  return {
    '--mouse-x': `${shiftX}px`,
    '--mouse-y': `${shiftY}px`,
  }
}
</script>
