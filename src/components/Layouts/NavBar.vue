<script lang="ts" setup>
import { useRouter } from 'vue-router';
const router = useRouter();
</script>

<template>
  <header class="mx-4 my-2">
    <nav class="navbar navbar-expand-lg p-3 shadow-sm">
      <div class="container-fluid">
        <router-link class="navbar-brand" to="#">Salah Monitor</router-link>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarNavDropdown"
          aria-controls="navbarNavDropdown"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNavDropdown">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item">
              <router-link
                class="nav-link mx-2"
                :class="{ active: router.currentRoute.value.name == 'monitor' }"
                aria-current="page"
                :to="{ name: 'monitor' }"
                >Monitor</router-link
              >
            </li>
            <li class="nav-item">
              <router-link
                class="nav-link mx-2"
                :class="{ active: router.currentRoute.value.name == 'jenis' }"
                :to="{ name: 'jenis' }"
                >Jenis</router-link
              >
            </li>
            <li class="nav-item dropdown">
              <a
                class="nav-link mx-2 dropdown-toggle"
                href="#"
                id="navbarDropdownMenuLink"
                role="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"
              >
                Username
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <li><a class="dropdown-item" href="#">Reset Password</a></li>
                <li><a class="dropdown-item" href="#">Logout</a></li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>
</template>
