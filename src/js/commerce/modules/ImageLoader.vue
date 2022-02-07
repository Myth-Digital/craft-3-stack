<template>
  <div class="preloader-image" :class="{ 'has-loaded': isLoaded() }">
    <transition name="fade">
      <img v-if="isLoaded()" :class="imgClass" :src="src" :alt="alt">
      <img v-else src="/img/placeholder.svg" alt="Loading">
    </transition>
  </div>
</template>

<script>

const STATUS = {
  LOADED: 'loaded',
  LOADING: 'loading',
  FAILED: 'failed'
}

export default {
  props: {
    src: {
      required: true,
      type: String
    },
    alt: {
      required: false,
      type: String
    },
    imgClass: {
      required: false,
      type: String
    }
  },

  data() {
    return {
      status: STATUS.LOADING,
      image: null
    }
  },
  created() {
    this.createLoader()
  },
  methods: {
    createLoader() {
      this.destroyLoader()
      this.status = STATUS.LOADING
      this.image = new Image()
      this.image.onload = this.onImageLoad
      this.image.onerror = this.onImageError
      this.image.src = this.src
    },
    destroyLoader() {
      if (this.image !== null) {
        this.image.onload = null
        this.image.onerror = null
        this.image = null
      }
    },
    onImageLoad() {
      this.destroyLoader()
      this.status = STATUS.LOADED
    },
    onImageError() {
      this.destroyLoader()
      this.status = STATUS.FAILED
    },
    isLoaded() {
      return this.status === STATUS.LOADED
    }
  }
}
</script>
