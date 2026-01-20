<template>
    <div :class="(modal ? '' : 'col-md-4 p-0 my-5 mx-auto ') + 'card card-default'">
        <div class="card-header text-center">
            <slot><span class="icon-wrapper icon-wrapper-primary"><user-plus-icon/></span></slot>
            <h5 class="card-title font-weight-bold">{{ $t('auth.register') }}</h5>
            <h6 class="card-subtitle mb-2 text-muted">{{ subtitle || $t('auth.register_text') }}</h6>
        </div>
        <div class="card-body">
            <form @keyup.enter="submitting ? null : register()">
                <alert v-show="alert.show" :type="alert.type" :content="alert.content"></alert>
                <div class="form-group mb-3 input-group">
                    <div class="input-group-prepend"><span class="input-group-text"><user-icon/></span></div>
                    <input v-model="username" :placeholder="$t('auth.username')" class="form-control" autofocus>
                </div>
                <div class="form-group mb-3 input-group">
                    <div class="input-group-prepend"><span class="input-group-text"><mail-icon/></span></div>
                    <input v-model="email" :placeholder="$t('auth.email')" class="form-control">
                </div>
                <div class="form-group input-group">
                    <div class="input-group-prepend"><span class="input-group-text"><lock-icon/></span></div>
                    <input type="password" v-model="password" :placeholder="$t('auth.password')" class="form-control">
                </div>
                <div class="text-center">
                    <button type="button" class="btn mt-4 btn-primary btn-lg btn-block" @click.prevent="register" :disabled="submitting || registered"><span class="spinner-border spinner-border-sm align-baseline" v-if="submitting"></span><template v-else>{{ $t('auth.register') }}</template></button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            modal: {
                type: Boolean,
                default: false
            },
            subtitle: {
                type: String,
                default: null
            }
        },
        data() {
            return {
                alert: {
                    show: false,
                    type: "danger",
                    content: "",
                },
                username: "",
                email: "",
                password: "",
                submitting: false,
                registered: false
            }
        },
        methods: {
            register() {
                this.submitting = true;
                this.$store.dispatch("register", {
                    username: this.username,
                    email: this.email,
                    password: this.password,
                }).then(response => {
                    this.$ga.event('users', 'registered');
                    this.handle_response(response, this.alert, false);
                    this.submitting = false;
                    this.registered = true;
                }).catch(error => {
                    this.handle_response(error.response, this.alert, true);
                    this.submitting = false;
                });
            },
            openModal(component) {
                if (this.modal) {
                    var parent = this.$parent;
                } else {
                    var parent = this.$parent.$parent;
                }
                parent.openModal(component);
            }
        }
    }
</script>

