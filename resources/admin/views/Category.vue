<template>
    <div>
        <v-card-title>
            Specialties
            <v-btn v-show="!item" class="mx-2" fab dark small color="primary"
                   @click="item={}">
                <v-icon dark>mdi-plus</v-icon>
            </v-btn>
            <div class="flex-grow-1"></div>
        </v-card-title>
        <div style="padding: 16px 16px 8px">
            <List v-if="!item" :delete-item="deleteItem"/>
        </div>
    </div>
</template>

<script>

    import List from "../components/Category/List";

    export default {
        data() {
            return {
                store: 'category',
                item: null
            }
        },
        components: {
            List
        },
        methods: {
            deleteItem(item) {
                if (confirm('Are you sure want to delete')){
                    return;
                    this.$store.dispatch(this.store + '/delete', item.id).then((response) => {
                        if (response.data == 'ok')
                            this.$store.dispatch(this.store + '/getItems');
                        this.item = null;
                    })
                }
            }
        },
    }

</script>
