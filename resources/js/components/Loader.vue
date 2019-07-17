<template>
    <div class="container-fluid app-loading bg-primary">
        <div class="col-6 m-auto">
            <div class="lds-ripple"><div></div><div></div></div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Loader"
}
</script>

<style scoped>
.app-loading {
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 100vh;
}
.lds-ripple {
    display: inline-block;
    position: relative;
    width: 256px;
    height: 256px;
    left: 50%;
    margin-left: -128px;
    margin-top: 35%;

}
.lds-ripple div {
    position: absolute;
    border: 4px solid #fff;
    opacity: 1;
    border-radius: 50%;
    animation: lds-ripple 1s cubic-bezier(0, 0.2, 0.8, 1) infinite;
}
.lds-ripple div:nth-child(2) {
    animation-delay: -0.5s;
}
</style>