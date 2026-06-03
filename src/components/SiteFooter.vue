<script setup>
import { inject } from 'vue'

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
              <svg class="footer-social-icon" viewBox="0 0 24 24" aria-hidden="true">
                <path
                  fill="currentColor"
                  d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4.64 6.8c-.15 1.58-.8 5.42-1.13 7.19-.14.75-.42 1-.68 1.03-.58.05-1.02-.38-1.58-.75-.88-.58-1.38-.94-2.23-1.5-.99-.65-.35-1.01.22-1.59.15-.15 2.71-2.48 2.76-2.69a.2.2 0 0 0-.05-.18c-.06-.05-.14-.03-.21-.02-.09.02-1.49.95-4.22 2.79-.4.27-.76.41-1.08.4-.36-.01-1.04-.2-1.55-.37-.63-.2-1.12-.31-1.08-.66.02-.18.27-.36.74-.55 2.92-1.27 4.86-2.11 5.83-2.51 2.78-1.16 3.35-1.36 3.73-1.36.08 0 .27.02.39.12.1.08.13.19.12.27-.01.06-.01.13-.02.2z"
                />
              </svg>
            </a>
            <a href="#" class="footer-social-link" aria-label="ВКонтакте">
              <svg class="footer-social-icon footer-social-icon--vk" viewBox="0 0 24 24" aria-hidden="true">
                <path
                  fill="currentColor"
                  d="M12.785 16.241s.288-.032.436-.194c.136-.148.132-.427.132-.427s-.02-1.283.58-1.472c.591-.184 1.35.926 2.154 1.334.604.294 1.062.229 1.062.229l2.135-.03s1.117-.071.587-.964c-.044-.073-.308-.661-1.588-1.87-1.34-1.264-1.16-1.059.453-3.246.983-1.332 1.376-2.145 1.253-2.493-.117-.327-.84-.241-.84-.241l-2.436.015s-.181-.025-.315.056c-.131.078-.214.26-.214.26s-.385 1.023-.897 1.893c-1.08 1.855-1.512 1.953-1.688 1.838-.411-.268-.308-1.075-.308-1.644 0-1.788.269-2.535-.526-2.725-.265-.064-.459-.106-1.137-.113-.87-.01-1.606.003-2.021.208-.277.144-.49.466-.36.484.162.022.528.099.722.363.251.344.242 1.114.242 1.114s.145 2.135-.337 2.402c-.331.193-.786-.2-1.762-1.995-.499-.87-.877-1.832-.877-1.832s-.073-.181-.204-.279c-.159-.119-.381-.156-.381-.156l-2.325.015s-.349.01-.477.162c-.114.135-.009.414-.009.414s1.816 4.246 3.87 6.387c1.882 1.958 4.027 1.829 4.027 1.829h.973Z"
                />
              </svg>
            </a>
          </div>
        </div>
      </div>
    </div>
  </footer>
</template>
