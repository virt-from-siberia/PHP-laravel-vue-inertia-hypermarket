<template>
  <div class="product-list">
    <!-- Header Section -->
    <header class="header">
      <h1 class="title">{{ pageTitle }}</h1>
      <button
        @click="handleCreateProduct"
        class="btn-primary"
        :disabled="isLoading"
      >
        <IconPlus />
        Add Product
      </button>
    </header>

    <!-- Search and Filters -->
    <div class="filters">
      <input
        v-model="searchQuery"
        type="text"
        placeholder="Search products..."
        @input="debouncedSearch"
        class="search-input"
      />

      <select v-model="selectedCategory" @change="filterProducts">
        <option :value="null">All Categories</option>
        <option
          v-for="category in categories"
          :key="category.id"
          :value="category.id"
        >
          {{ category.name }} ({{ category.products_count }})
        </option>
      </select>
    </div>

    <!-- Products Grid -->
    <div v-if="!isLoading" class="products-grid">
      <div
        v-for="product in filteredProducts"
        :key="product.id"
        class="product-card"
        :class="{ featured: product.is_featured }"
      >
        <img :src="product.image" :alt="product.name" loading="lazy" />
        <h3>{{ product.name }}</h3>
        <p class="description">{{ truncate(product.description, 100) }}</p>
        <div class="price-section">
          <span class="price">{{ formatPrice(product.price) }}</span>
          <span v-if="product.discount" class="discount">
            -{{ product.discount }}%
          </span>
        </div>
        <button @click="addToCart(product)" class="btn-add-cart">
          Add to Cart
        </button>
      </div>
    </div>

    <!-- Loading State -->
    <div v-else class="loading">
      <span class="spinner"></span>
      Loading products...
    </div>

    <!-- Empty State -->
    <div v-if="!isLoading && filteredProducts.length === 0" class="empty-state">
      <p>No products found</p>
    </div>

    <!-- Pagination -->
    <pagination
      v-if="pagination.total > pagination.per_page"
      :current-page="pagination.current_page"
      :total-pages="pagination.last_page"
      @page-changed="loadPage"
    />
  </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted, watch } from "vue";
import { router } from "@inertiajs/vue3";
import { debounce } from "lodash";
import IconPlus from "@/Components/Icons/IconPlus.vue";
import Pagination from "@/Components/Pagination.vue";

// Props
interface Props {
  products: Product[];
  categories: Category[];
  filters?: Filters;
}

const props = defineProps<Props>();

// Types
interface Product {
  id: number;
  name: string;
  description: string;
  price: number;
  discount?: number;
  image: string;
  is_featured: boolean;
  category_id: number;
}

interface Category {
  id: number;
  name: string;
  products_count: number;
}

// Reactive State
const isLoading = ref(false);
const searchQuery = ref(props.filters?.search || "");
const selectedCategory = ref<number | null>(props.filters?.category || null);
const pageTitle = ref("Product Catalog");

// Computed Properties
const filteredProducts = computed(() => {
  let products = props.products;

  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase();
    products = products.filter(
      (p) =>
        p.name.toLowerCase().includes(query) ||
        p.description.toLowerCase().includes(query)
    );
  }

  if (selectedCategory.value) {
    products = products.filter((p) => p.category_id === selectedCategory.value);
  }

  return products;
});

const pagination = computed(() => ({
  current_page: 1,
  last_page: 10,
  per_page: 15,
  total: 150,
}));

// Methods
const handleCreateProduct = () => {
  router.visit("/products/create");
};

const filterProducts = () => {
  isLoading.value = true;
  router.get(
    "/products",
    {
      category: selectedCategory.value,
      search: searchQuery.value,
    },
    {
      preserveState: true,
      onFinish: () => (isLoading.value = false),
    }
  );
};

const debouncedSearch = debounce(() => {
  filterProducts();
}, 300);

const addToCart = async (product: Product) => {
  try {
    await router.post("/cart/add", {
      product_id: product.id,
      quantity: 1,
    });
    alert(`${product.name} added to cart!`);
  } catch (error) {
    console.error("Error adding to cart:", error);
  }
};

const formatPrice = (price: number): string => {
  return new Intl.NumberFormat("en-US", {
    style: "currency",
    currency: "USD",
  }).format(price);
};

const truncate = (text: string, length: number): string => {
  return text.length > length ? text.substring(0, length) + "..." : text;
};

const loadPage = (page: number) => {
  router.get(`/products?page=${page}`);
};

// Lifecycle Hooks
onMounted(() => {
  console.log("Component mounted with", props.products.length, "products");
});

// Watchers
watch(
  () => props.products,
  (newProducts) => {
    console.log("Products updated:", newProducts.length);
  }
);
</script>

<style scoped lang="scss">
.product-list {
  padding: 2rem;
  max-width: 1200px;
  margin: 0 auto;

  .header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;

    .title {
      font-size: 2rem;
      font-weight: 700;
      color: #1a202c;
    }

    .btn-primary {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      padding: 0.75rem 1.5rem;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      transition: all 0.3s ease;

      &:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
      }

      &:disabled {
        opacity: 0.6;
        cursor: not-allowed;
      }
    }
  }

  .filters {
    display: flex;
    gap: 1rem;
    margin-bottom: 2rem;

    .search-input {
      flex: 1;
      padding: 0.75rem;
      border: 2px solid #e2e8f0;
      border-radius: 8px;
      font-size: 1rem;

      &:focus {
        outline: none;
        border-color: #667eea;
      }
    }
  }

  .products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 2rem;

    .product-card {
      background: white;
      border-radius: 12px;
      padding: 1rem;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease;

      &:hover {
        transform: translateY(-4px);
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
      }

      &.featured {
        border: 2px solid #fbbf24;
      }

      img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 8px;
      }

      .price-section {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin: 1rem 0;

        .price {
          font-size: 1.5rem;
          font-weight: 700;
          color: #667eea;
        }

        .discount {
          padding: 0.25rem 0.5rem;
          background: #fbbf24;
          color: white;
          border-radius: 4px;
          font-size: 0.875rem;
        }
      }
    }
  }

  .loading {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 1rem;
    padding: 4rem;
    font-size: 1.25rem;
    color: #718096;
  }
}
</style>
