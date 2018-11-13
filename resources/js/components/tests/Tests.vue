<template>
    <div class="container">
        <div class="row">
            <table class="table table-bordered">
                <thead>
                    <tr class="table-thead">
                        <th>TITLE</th>
                        <th>CREATED</th>
                        <th>RESPONSES</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>test</td>
                        <td>test222</td>
                        <td>test344</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="btn-group" role="group">
                <router-link class="btn btn-secondary" to="tests/create">Create</router-link>
            </div>
        </div>
    </div>
</template>

<script>
export default {

}
</script>

<style scoped>
.table-thead {
    background-color: #5f2a62;
    color: #fff;
}
.table tbody tr {
    background-color: #fff;
}
</style>