<template>
    <div class="grid gap-3 gap-y-6 grid-cols-1 sm:grid-cols-2 relative mb-5">
        <c-input v-model="value.firstName" :error="getError('firstName')" :required="true" name="firstName" type="text" placeholder="Enter your first name" label="First name*" @input="updateData()" />
        <c-input v-model="value.lastName" :error="getError('lastName')" :required="true" name="lastName" type="text" placeholder="Enter your last name" label="Last name*" @input="updateData()" />
        <c-input v-model="value.address1" :error="getError('address1')" :required="true" name="address1"  type="text" placeholder="Enter your address" label="Address line 1*" @input="updateData()" />
        <c-input v-model="value.address2" :error="getError('address2')" name="address2"  type="text" placeholder="" label="Address line 2" @input="updateData()" />
        <c-input v-model="value.city" :error="getError('city')" :required="true" name="city"  type="text" placeholder="Enter your city" label="City*" @input="updateData()" />
        <c-input v-model="value.zipCode" :error="getError('zipCode')" :required="true" name="zipCode"  type="text" placeholder="Enter your postcode" label="Postcode*" @input="updateData()" />
        <c-input v-model="value.phone" :error="getError('phone')" :required="true" name="phone"  type="text" placeholder="Enter your phone" label="Phone*" @input="updateData()" />
        <c-select v-model="value.countryId" :options="countries" :error="getError('countryId')" :required="true" name="countryId" placeholder="Please select your country" label="Country*" @input="updateData()" />
        <c-select v-if="statesForCountry.length > 0" v-model="value.stateValue" :options="statesForCountry" :error="getError('stateValue')" name="stateValue" placeholder="Please select your state" label="State" @input="updateData()" />
    </div>
</template>

<script>
export default {
    name: 'delivery-address',
    props: {
        value: Object,
        errorRoot: String,
        validCountries: Array
    },
    created() {
        this.$store.dispatch('standingData/getCountries');
        this.$store.dispatch('standingData/getStates');
    },
    data() {
        return {
            isLoading: false
        }
    },
    mounted() {
        // this.updateData();
    },
    computed: {
        countries() {
            let countryList = this.$store.state.standingData.countries;

            if (this.validCountries && this.validCountries.length > 0) {
                let newCountryList = {};
                this.validCountries.forEach(element => {
                    newCountryList[element] = countryList[element];
                });
                return newCountryList;
            }
            return countryList;
        },
        states() {
            return this.$store.state.standingData.states;
        },
        statesForCountry() {
            if (!this.value.countryId) return [];

            if (!this.states) return [];

            return this.states.filter(s => s.countryId === this.value.countryId);
        }
    },
    methods: {
        getError(field) {
            let errorPath = `${this.errorRoot}.${field}`;
            return this.getCartError(errorPath);
        },
        updateData() {
            this.$emit('input', {
                firstName: this.$refs.firstName.value,
                lastName: this.$refs.lastName.value,
                address1: this.$refs.address1 ? this.$refs.address1.value : null,
                address2: this.$refs.address2 ? this.$refs.address2.value : null,
                city: this.$refs.city ? this.$refs.city.value : null,
                zipCode: this.$refs.zipCode ? this.$refs.zipCode.value : null,
                phone: this.$refs.phone.value,
                countryId: this.$refs.countryId ? this.$refs.countryId.value : null,
                stateValue: this.$refs.stateValue ? this.$refs.stateValue.value : null
            })
        }        
    }    
}
</script>