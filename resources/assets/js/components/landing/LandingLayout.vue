<template>
<div>
<p>Landing Layout</p>
  <ul class="nav navbar-nav">
        <li><router-link to="/">Home</router-link></li>
        <li><router-link to="/test">Test</router-link></li>
        <li><router-link to="/prueba">Prueba</router-link></li>
        <li><router-link to="/topics">Topics</router-link></li>
      </ul>
<router-view></router-view>
</div>
</template>

<script>
export default {
}
</script>