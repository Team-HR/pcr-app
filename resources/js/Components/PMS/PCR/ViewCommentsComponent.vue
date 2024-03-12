<template>
    <div>
        <Button
            label="View Comments"
            size="small"
            class="p-2 bg-red-300"
            style="position: absolute; left: -135px"
            @click="showComments"
        ></Button>
        <OverlayPanel ref="op">
            <div class="flex flex-column gap-3 w-25rem">
                <!-- {{ correction_comments_data }} -->
                <template v-for="(comment, i) in correction_comments_data">
                    <div class="card">
                        <p class="uppercase">
                            "{{ comment.correction_comments }}"
                        </p>
                        <i class="text-xs uppercase">
                            -- {{ comment.created_by }} /
                            {{ comment.created_by_type }} ({{
                                comment.created_at
                            }})
                        </i>
                    </div>
                </template>
            </div>
        </OverlayPanel>
    </div>
</template>

<script>
export default {
    props: ["correction_comments_data"],
    methods: {
        showComments(event) {
            this.$refs.op.toggle(event);
        },
    },
};
</script>
