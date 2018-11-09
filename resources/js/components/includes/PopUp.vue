<template>
    <div id="popup" :class="[ isShowPopup ? 'show' : '', 'cs-popup-layout']">
        <div class="popup-content" v-click-outside="outside">
            <slot name="header">
                <header class="d-flex justify-space-between align-center">
                    <h4 class="title-popup">{{ titlePopup }}</h4>
                    <i class="dripicons-cross close-popup" @click="$emit('close')"></i>
                </header>
            </slot>
            <slot name="content">
                <div class="content">
                    <form action="">
                        <div class="form-group">

                            <p>{{ contentPopup }}</p>

                        </div>
                        <footer class="text-right">
                            <button type="button" class="btn-sm btn-gray close-popup margin-right-10"
                                    @click="$emit('close')">Hủy
                            </button>
                            <button type="button" class="btn-sm btn-primary-custom" @click="$emit('ok')">
                                Đồng ý
                            </button>
                        </footer>
                    </form>
                </div>
            </slot>
        </div>
    </div>
</template>

<script>
  export default {
    props: ['title', 'content', 'isShowPopup'],

    watch: {
      title: function (value) {
        this.titlePopup = value;
      },
      content: function (value) {
        this.contentPopup = value;
      }
    },

    methods: {
      outside() {
        if (this.isShowPopup) {
          this.$emit('close');
        }
      },
    },

    data() {
      return {
        titlePopup: this.title,
        contentPopup: this.content,
      }
    },
  }
</script>
