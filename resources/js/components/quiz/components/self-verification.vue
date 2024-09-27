<template>
    <div class="self-verification-container p-4">
        <div class="self-verification d-flex flex-column">
            <div class="py-2 pl-1" style="font-size: 20px">Self Verification</div>
            <div class="d-flex flex-row">
                <div class="d-flex flex-column w-50">
                    <div class="self-verification-option">
                        <input class="inline-edit" type="text" name="verification_text_1"
                                v-model="verification_text_1" v-on:change="updateText('verification_text_1')"
                               id="verification_text_1">
                        <label for="verification_text_1">
                            <i class="flaticon-edit"></i>
                        </label>
                    </div>
                    <div class="self-verification-option">
                        <input class="inline-edit" type="text" name="verification_text_2"
                                v-model="verification_text_2" v-on:change="updateText('verification_text_2')"
                               id="verification_text_2">
                        <label for="verification_text_2">
                            <i class="flaticon-edit"></i>
                        </label>
                    </div>
                    <div class="self-verification-option">
                        <input class="inline-edit" type="text" name="verification_text_3"
                                v-model="verification_text_3" v-on:change="updateText('verification_text_3')"
                               id="verification_text_3">
                        <label for="verification_text_3">
                            <i class="flaticon-edit"></i>
                        </label>
                    </div>
                </div>
                <div class="d-flex flex-column w-50">
                    <div class="self-verification-option">
                        <input class="inline-edit" type="text" name="verification_text_4"
                                v-model="verification_text_4" v-on:change="updateText('verification_text_4')"
                               id="verification_text_4">
                        <label for="verification_text_4">
                            <i class="flaticon-edit"></i>
                        </label>
                    </div>
                    <div class="self-verification-option">
                        <input class="inline-edit" type="text" name="verification_text_5"
                               v-model="verification_text_5" v-on:change="updateText('verification_text_5')"
                               id="verification_text_5">
                        <label for="verification_text_5">
                            <i class="flaticon-edit"></i>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "self-verification",
        data() {
            return {
                verification_text_1: null,
                verification_text_2: null,
                verification_text_3: null,
                verification_text_4: null,
                verification_text_5: null,
            }
        },
        props: [
            'quiz_id',
        ],
        methods: {

            updateText(name) {
                const data = {
                    [name]: this[name],
                };
                fetch(`/dashboard/quizes/${this.quiz_id}`, {
                    method: "PATCH",
                    headers: {
                        'Content-type': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    body: JSON.stringify(data)
                });
            }
        },
        mounted() {
            fetch(`/dashboard/quizes/${this.quiz_id}/self-verification`)
                .then(response => response.json())
                .then(data => {
                    this.verification_text_1 = data.verification_text_1;
                    this.verification_text_2 = data.verification_text_2;
                    this.verification_text_3 = data.verification_text_3;
                    this.verification_text_4 = data.verification_text_4;
                    this.verification_text_5 = data.verification_text_5;
                });
        }
    }
</script>

<style lang="scss">
    .self-verification .inline-edit {
        border: 0;
        border-bottom: 1px solid silver;
        width: 80%;
    }

    .self-verification .self-verification-option {
        padding: 3px;
    }
</style>
