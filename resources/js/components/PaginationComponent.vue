<template>

  <ul class="pagination justify-content-center">
    <li class="page-item">
      <button
        type="button"  class="page-linkk"
        @click="onClickFirstPage"
        :disabled="isInFirstPage"
        aria-label="Ir a la primera página."
      >
        Primero
      </button>
    </li>
    <li class="page-item"><button  class="page-linkk"
        type="button"
        @click="onClickPreviousPage"
        :disabled="isInFirstPage"
        aria-label="Ir a la pagina anterior."
      >
        Anterior
      </button></li>

    <li class="page-item" v-for="(page,index) in pages"  :key="index"><button
        type="button"  class="page-linkk"
        @click="onClickPage(page.name)"
        :disabled="page.isDisabled"
        :class="{ activar: isPageActive(page.name) }"
        :aria-label="`Ir a l página número ${page.name}`"

      >
        {{ page.name }}
      </button></li>
    <li class="page-item"><button
        type="button"  class="page-linkk"
        @click="onClickNextPage"
        :disabled="isInLastPage"
        aria-label="Ir a la siguiente página."
      >
        Siguiente
      </button></li>
    <li class="page-item">
      <button
        type="button"  class="page-linkk"
        @click="onClickLastPage"
        :disabled="isInLastPage"
        aria-label="Ir a la última página."
      >
        Último
      </button>
    </li>
  </ul>



</template>

<script>
export default {

    props: {
    maxVisibleButtons: {
      type: Number,
      required: false,
      default: 3
    },
    totalPages: {
      type: Number,
      required: true
    },
    total: {
      type: Number,
      required: true
    },
    perPage: {
      type: Number,
      required: true
    },
    currentPage: {
      type: Number,
      required: true
    },
  },
  computed: {
    startPage() {
      if (this.currentPage === 1) {
        return 1;
      }

    if (this.currentPage === this.totalPages) {
        const start = this.totalPages - (this.maxVisibleButtons - 1);

        if (start === 0) {
        return 1;
        } else {
        return start;
        }
    }

      return this.currentPage - 1;

    },
    endPage() {

      return Math.min(this.startPage + this.maxVisibleButtons - 1, this.totalPages);

    },
    pages() {
      const range = [];

      for (let i = this.startPage; i <= this.endPage; i+= 1 ) {
        range.push({
          name: i,
          isDisabled: i === this.currentPage
        });
      }

      return range;
    },
    isInFirstPage() {
      return this.currentPage === 1;
    },
    isInLastPage() {
      return this.currentPage === this.totalPages;
    },
  },
  methods: {
    onClickFirstPage() {
      this.$emit('pagechanged', 1);
    },
    onClickPreviousPage() {
      this.$emit('pagechanged', this.currentPage - 1);
    },
    onClickPage(page) {
      this.$emit('pagechanged', page);
    },
    onClickNextPage() {
      this.$emit('pagechanged', this.currentPage + 1);
    },
    onClickLastPage() {
      this.$emit('pagechanged', this.totalPages);
    },
    isPageActive(page) {
      return this.currentPage === page;
    },
  }
}
</script>

<style>
.activar {
  background-color: #4AAE9B;
  color: #ffffff;
}
.page-linkk{
    position: relative;
    display: block;
    padding: .5rem .75rem;
    margin-left: -1px;
    line-height: 1.25;
    color: #138496;
    /* background-color: #fff; */
    border: 1px solid #dee2e6;
}
</style>
