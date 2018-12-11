<template>
    <div class="container">
        <!-- Edit info -->
        <div class="jumbotron">
            <form @submit.prevent>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-10">
                            <label for="title">Title</label>
                            <input id="title" type="text" class="form-control"
                                   :disabled="!editFields"
                                   :value="title">
                        </div>
                        <div class="col-md-2 mt-3 mt-md-0"
                             v-show="!editFields">
                            <button class="btn btn-secondary btn-block"
                                    @click="edit">
                                Edit
                            </button>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-10 text-right"
                             v-show="editFields">
                            <a @click.prevent="cancelEdit" class="edit-link" href="">Cancel</a>
                            <button class="btn btn-success">Save</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="jumbotron">
            <h3>Questions</h3>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <button class="btn btn-success">New question</button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="create-question">
                        <!--question-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            title: '',
            editFields: false
        }
    },
    methods: {
        edit() {
            this.editFields = true;
        },
        cancelEdit() {
            this.editFields = false;
        }
    },
    beforeCreate() {
        let id = this.$route.params.id;

        this.axios.get(`/survey/get/${id}`)
            .then((res) => {
                this.title = res.data.survey[0].title;
            })
            .catch((err) => {
                this.$toasted.show('Forbidden');
                this.$router.push({ path: '/tests' });
            });
    }
}
</script>

<style scoped>
.jumbotron {
    background-color: #EAF0F5;
}
.edit-link {
    color: #0f070f;
    margin: 0 25px;
}
.create-question {
    border-top: 2px solid #fff;
    border-bottom: 2px solid #fff;
    padding: 15px;
}
</style>