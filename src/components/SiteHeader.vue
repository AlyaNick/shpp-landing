<template>
  <header class="site-header">
    <div class="site-header__inner">
      <a href="#top" class="brand">ШПП</a>

      <nav class="nav" :class="{ 'is-open': navOpen }">
        <a href="#about" @click="navOpen = false">О нас</a>
        <a href="#benefits" @click="navOpen = false">Услуги</a>
        <a href="#contacts" @click="navOpen = false">Контакты</a>
      </nav>

      <a class="header-btn" href="#register">Регистрация</a>
      <button class="menu-btn" type="button" aria-label="Открыть меню" @click="navOpen = !navOpen">
        <span></span><span></span><span></span>
      </button>
    </div>
  </header>
</template>

<script setup>
import { ref } from 'vue'

const navOpen = ref(false)
</script>