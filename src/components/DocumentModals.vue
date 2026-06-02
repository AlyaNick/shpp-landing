<script setup>
import { ref } from 'vue'
import PolicyDocument from './documents/PolicyDocument.vue'
import ConsentDocument from './documents/ConsentDocument.vue'

const policyRef = ref(null)
const consentRef = ref(null)

function open(doc) {
  if (doc === 'policy') {
    policyRef.value?.open()
  } else {
    consentRef.value?.open()
  }
}

defineExpose({ open })
</script>

<template>
  <PolicyDocument ref="policyRef" />
  <ConsentDocument ref="consentRef" />
</template>
