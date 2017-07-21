<template>
<div>
    <form v-on:submit.prevent="Search(currentPage,'searchForm')">
        <div class="form-group">
        <label for="name">Name</label>
        <input  name ="name" type="text" v-model="name" class="form-control">
        </div>
        <div class="form-group">
        <label for="name">Description</label>
        <input name ="description" type="text" v-model="description" class="form-control">
        </div>
        <div class="form-group">
        <button type="submit" class="btn btn-primary">Guardar</button>  
        </div>
    </form>
</div>  
</template>

<script>
export default {
    
}
</script>