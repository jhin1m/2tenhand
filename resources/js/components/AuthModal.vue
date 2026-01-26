<template>
    <div class="modal fade" id="auth-modal">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <transition name="fade" mode="out-in">
                    <component :modal="true" :is="component" v-if="component"></component>
                </transition>
            </div>
        </div>
    </div>
</template>
<script>
import Login from './auth/Login';
import Register from './auth/Register';
import PasswordReset from './auth/PasswordReset';

export default {
    name: "auth-modal",
    components: {
        Login,
        Register,
        PasswordReset
    },
    data() {
        return {
            component: null
        };
    },
    methods: {
        openModal(componentName) {
            this.component = componentName;
            var modal = document.querySelector('#auth-modal');
            if (!modal.classList.contains('show')) {
                new this.$bootstrap.Modal(modal).show();
            }
        },
        hideModal() {
            new this.$bootstrap.Modal(document.querySelector('#auth-modal')).hide();
        }
    }
};
</script>
