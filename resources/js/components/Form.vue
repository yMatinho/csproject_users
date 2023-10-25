<template>
    <form :form_id="this.form_id" :method="this.method" :action="this.action" enctype="multipart/form-data">
        <slot></slot>
        
        <div class="form-group">
            <input type="submit" name="action" @click.prevent="submitForm" :value="this.action_label">
        </div>
    </form>
</template>

<script>
import Input from './Input.vue';
import axios from "axios"

    export default {
    props: ["method", "action", "action_label", "ajax", "form_id"],
    components: { Input },
    methods: {
        submitForm: function() {
            let event = {validationPassed: true}
            this.$emit("checkRequired", event)
            if(!event.validationPassed)
                return false

            let form = document.querySelector("[form_id="+this.form_id+"]")
            if(this.ajax) {
                if(this.method == "post")
                    axios.post(this.action, new FormData(form))
                else
                    axios.get(this.action, new FormData(form))
            } else {
                form.submit()
            }
        }
    }
}
</script>