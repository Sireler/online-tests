<template>
    <div class="row h-100 justify-content-center align-items-center">
        <div class="main col-md-12">
            <div class="col-md-12">
                <div class="container col-md-6 text-white">
                    <h3 class="display-4">Log in</h3>
                </div>
                <div class="container col-md-6 bg-white rounded border border-info">
                    <form v-on:submit.prevent class="p-5">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <input type="text" v-model="inputEmail" class="form-control" placeholder="Email" value="" />
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="password" v-model="inputPassword" class="form-control" placeholder="Password" value="" />
                        </div>
                        <div class="form-group">
                            <input @click="login" type="submit" class="btn btn-outline-primary" value="Continue" />
                        </div>
                        <div class="form-group">
                            <a href="#">Forget Password?</a>
                        </div>
                    </form>
                </div>
                <div class="container col-md-6">
                    <a class="text-white"
                       href="#signup"
                       @click.prevent="showRegForm">Sign up</a>
                </div>
            </div>
        </div>
    </div>


</template>

<script>
export default {
    data() {
        return {
            inputEmail: '',
            inputPassword: ''
        }
    },
    methods: {
        showRegForm() {
            this.$emit('changeView', 'register');
        },

        login() {
            if (this.checkInputs()) {
                this.$auth.login({
                    data: {
                        email: this.inputEmail,
                        password: this.inputPassword
                    },
                    redirect: '/home',
                    fetchUser: true,
                    success: (res) => {
                        this.$toasted.show('You are logged in');
                    },
                    error: (res) => {
                        this.$toasted.show('Email or password incorrect');
                        this.clearInputs();
                    },
                    rememberMe: true
                });
            } else {
                this.$toasted.show('All input fields must be filled');
            }
        },

        clearInputs() {
            this.inputEmail = '';
            this.inputPassword = '';
        },
        checkInputs() {
            return this.inputEmail.length > 0 && this.inputPassword.length > 0;
        }
    }
}
</script>

<style scoped>


</style>