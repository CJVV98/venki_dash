<template>
    <div>
        <!-- begin breadcrumb -->
        <ol class="breadcrumb float-xl-right">
            <li class="breadcrumb-item active">
                <a href="javascript:;">Home</a>
            </li>
        </ol>
        <!-- end breadcrumb -->
        <!-- begin page-header -->
        <h1 class="page-header">
            Home <small>header small text goes here...</small>
        </h1>
        <!-- end page-header -->
        <panel title="Panel title here">
            <p>
                Panel content here
            </p>
        </panel>
    </div>
</template>

<script type="text/javascript">
// import axios from "axios";

export default {
    created() {
        // this.getUser();
    },
    methods: {
      /*getUser(){
        axios.get('/api/user').then( response => {
            this.name = response.data.name;
        })
      }*/
    },
    data() {
        return {
            name: ''
        }
    }
}

</script>
