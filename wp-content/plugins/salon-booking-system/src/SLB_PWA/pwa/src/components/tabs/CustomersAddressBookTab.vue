<template>
    <div>
        <ImagesList :customer="customer" v-if="isShowImages" @close="closeShowImages"/>
        <CustomersAddressBook :shop="shop" v-show="!isShowImages" @showImages="showImages" :customer="customerData"/>
    </div>
</template>

<script>

    import CustomersAddressBook from './customers-address-book/CustomersAddressBook.vue'
    import ImagesList from './customers-address-book/ImagesList.vue'

    export default {
        name: 'CustomersAddressBookTab',
        props: {
            shop: {
                default: function () {
                    return {};
                },
            }
        },
        components: {
            CustomersAddressBook,
            ImagesList,
        },
        data: function () {
            return {
                isShowImages: false,
                customer: null,
                customerData: null,
            }
        },
        methods: {
            showImages(customer) {
                this.isShowImages = true;
                this.customer = customer;
                this.$emit('hideTabsHeader', true)
            },
            closeShowImages(customer) {
                this.isShowImages = false;
                this.customerData = customer
                this.$emit('hideTabsHeader', false)
            },
        },
        emits: ['hideTabsHeader']
    }
</script>

<style>

</style>