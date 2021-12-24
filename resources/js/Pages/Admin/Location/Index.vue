<template>
    <admin-layouts navbarTitle="lokasi">
        <Head title="Lokasi" />
        <Toast />
        <div class="flex flex-wrap mt-4">
            <div class="w-full mb-12 px-4">
                <div
                    class="
                        relative
                        flex flex-col
                        min-w-0
                        break-words
                        w-full
                        mb-6
                        shadow-lg
                        rounded
                        bg-white
                    "
                >
                    <div id="map" style="width: 100%; height: 530px"></div>
                    <div class="p-grid p-fluid" v-if="this.lat.lat">
                        <form id="form" @submit.prevent="submit">
                            <div class="p-col-4 p-md-4">
                                <InputText
                                    type="text"
                                    v-model="this.lat.lat.lat"
                                    disabled
                                />
                            </div>
                            <div class="p-col-4 p-md-4">
                                <InputText
                                    type="text"
                                    v-model="this.lat.lat.lng"
                                    disabled
                                />
                            </div>
                            <div class="p-col-4 p-md-4">
                                <div class="p-inputgroup">
                                    <InputText
                                        type="text"
                                        v-model="this.lat.lat.radius"
                                    />
                                    <span class="p-inputgroup-addon"
                                        >Meter</span
                                    >
                                </div>
                            </div>
                            <Button title="update" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </admin-layouts>
</template>
<script>
import AdminLayouts from "@/Layouts/Admin.vue";
import { Head } from "@inertiajs/inertia-vue3";
import Button from "@/Components/notus/FormComponent/Button.vue";
import { Inertia } from "@inertiajs/inertia";
import Toast from "primevue/toast";
import InputText from "primevue/inputtext";

export default {
    props: { locate: Object, flash: Object },
    components: {
        AdminLayouts,
        Head,
        Button,
        Toast,
        InputText,
    },
    data() {
        return {
            lat: {},
        };
    },
    created() {
        console.log("up :>> ", this.locate);
    },
    mounted() {
        console.log("mount :>> ", this.locate);
        this.onWindowLoad();
        this.successAlert();
    },
    beforeUpdate() {
        this.load();
    },
    methods: {
        load() {
            console.log("this.locate :>> ", this.locate);
        },
        onWindowLoad() {
            L.mapquest.key = "bHGSG3mk9KmuGZmXDPnBgzUGIdd8kGAF";
            var popup = L.popup();
            var map = L.mapquest.map("map", {
                center: [this.locate.lat, this.locate.lng],
                layers: L.mapquest.tileLayer("map"),
                zoom: 15,
            });

            L.marker([this.locate.lat, this.locate.lng], {
                icon: L.mapquest.icons.marker(),
                draggable: false,
            })
                .bindPopup("Lokasi")
                .addTo(map);

            L.circle([this.locate.lat, this.locate.lng], {
                radius: this.locate.radius,
            }).addTo(map);

            map.addControl(L.mapquest.control());
            var vm = this;
            map.on("click", function (e) {
                vm.lat = {
                    lat: {
                        lat: e.latlng.lat,
                        lng: e.latlng.lng,
                        radius: vm.locate.radius,
                    },
                };
                popup.setLatLng(e.latlng).openOn(this);
                L.mapquest.geocoding().reverse(e.latlng, generatePopupContent);
            });
            function generatePopupContent(error, response) {
                var location = response.results[0].locations[0];
                var street = location.street;
                var city = location.adminArea5;
                var state = location.adminArea3;

                popup.setContent(street + ", " + city + ", " + state);
            }
        },
        findIndexById(id) {
            let index = 1;
            for (let i = 0; i < this.locate.length; i++) {
                if (this.locate[i].id === id) {
                    index = i;
                    break;
                }
            }

            return index;
        },

        submit() {
            this.locate[this.findIndexById(1)] = this.lat.lat;
            if (this.locate.id == 1) {
                this.locate.lat = this.lat.lat.lat;
                this.locate.lng = this.lat.lat.lng;
            }
            console.log(
                "this.locate2 :>> ",
                (this.locate[this.findIndexById(1)] = this.lat.lat)
            );

            Inertia.post(route("location.store", this.lat.lat));
            console.log("this.locate3 :>> ", this.locate);
            this.locate;
        },
        successAlert() {
            if (this.flash.message != null) {
                this.$toast.add({
                    severity: "success",
                    summary: "Success Message",
                    detail: this.flash.message,
                    life: 3000,
                });
            }
        },
    },
};
</script>
