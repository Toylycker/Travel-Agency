<template>
    <div v-if="place.videos.length>0" class="container-fluid text-center border my-3">
        <h1>PLace For Video</h1>
    </div>
    <div class="row">
        <div class="col-6">
            <div id="placeCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div v-for="image in place.images" :key="image.id" class="carousel-item active">
                        <!-- <img src="..." class="d-block w-100" alt="..."> -->
                        <img :src="'/storage/places/' + image.name" class="img-fluid d-block rounded w-100">
                    </div>
                </div>
                <button v-if="place.images.length > 1" class="carousel-control-prev" type="button"
                    data-bs-target="#placeCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button v-if="place.images.length > 1" class="carousel-control-next" type="button"
                    data-bs-target="#placeCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
        <div class="col-6">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d198.3203106185617!2d58.403554929153735!3d37.92136351864352!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3f6ffd96267b8f65%3A0x42c6912c159dd4b8!2sMini%20market!5e0!3m2!1sen!2s!4v1664365622460!5m2!1sen!2s"
                width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>

        </div>
    </div>
    <div>
        <div class="container g-0" v-for="(text, i) in place.texts" :key="text.id" :data-i="i">
            <h4 v-if="text.title" class="text-center">{{ text.title }}</h4>
            <div class="clearfix m-3">
                <!-- <img :src="'/img/1.jpeg'" alt="..."
                    class="col-md-4 mb-3 m-md-2 img-fluid img h-25" :class="(i % 2===0)?'float-md-start':'float-md-end'"> -->
                <div v-if="text.images.length > 0" class="col-md-4 mb-3 m-md-2 img-fluid img h-25"
                    :class="(i % 2 === 0) ? 'float-md-start' : 'float-md-end'">
                    <div :id="'text_image' + text.id" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div v-for="imag in text.images" :key="imag.id" class="carousel-item active">
                                <!-- <img src="..." class="d-block w-100" alt="..."> -->
                                <img :src="'/storage/texts/' + imag.name" class="img-fluid d-block rounded w-100">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" :data-bs-target="'#text_image' + text.id"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" :data-bs-target="'#text_image' + text.id"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>

                </div>
                <div>
                    <p>
                        {{ text.body }}
                        Lorem ipsum dolor, sit amet consectetur adipisicing elit. Illo enim quibusdam quo ad, voluptate
                        iste quam totam ipsum repellendus maiores molestiae sit deserunt corporis accusamus in et animi
                        iure aperiam?
                        Lorem ipsum dolor, sit amet consectetur adipisicing elit. Illo enim quibusdam quo ad, voluptate
                        iste quam totam ipsum repellendus maiores molestiae sit deserunt corporis accusamus in et animi
                        iure aperiam?
                        Lorem ipsum dolor, sit amet consectetur adipisicing elit. Illo enim quibusdam quo ad, voluptate
                        iste quam totam ipsum repellendus maiores molestiae sit deserunt corporis accusamus in et animi
                        iure aperiam?
                        Lorem ipsum dolor, sit amet consectetur adipisicing elit. Illo enim quibusdam quo ad, voluptate
                        iste quam totam ipsum repellendus maiores molestiae sit deserunt corporis accusamus in et animi
                        iure aperiam?
                        Lorem ipsum dolor, sit amet consectetur adipisicing elit. Illo enim quibusdam quo ad, voluptate
                        iste quam totam ipsum repellendus maiores molestiae sit deserunt corporis accusamus in et animi
                        iure aperiam?
                        Lorem ipsum dolor, sit amet consectetur adipisicing elit. Illo enim quibusdam quo ad, voluptate
                        iste quam totam ipsum repellendus maiores molestiae sit deserunt corporis accusamus in et animi
                        iure aperiam?
                        Lorem ipsum dolor, sit amet consectetur adipisicing elit. Illo enim quibusdam quo ad, voluptate
                        iste quam totam ipsum repellendus maiores molestiae sit deserunt corporis accusamus in et animi
                        iure aperiam?
                        Lorem ipsum dolor, sit amet consectetur adipisicing elit. Illo enim quibusdam quo ad, voluptate
                        iste quam totam ipsum repellendus maiores molestiae sit deserunt corporis accusamus in et animi
                        iure aperiam?
                        Lorem ipsum dolor, sit amet consectetur adipisicing elit. Illo enim quibusdam quo ad, voluptate
                        iste quam totam ipsum repellendus maiores molestiae sit deserunt corporis accusamus in et animi
                        iure aperiam?
                        Lorem ipsum dolor, sit amet consectetur adipisicing elit. Illo enim quibusdam quo ad, voluptate
                        iste quam totam ipsum repellendus maiores molestiae sit deserunt corporis accusamus in et animi
                        iure aperiam?
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>



<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
const props = defineProps(['place']);

</script>
<script>
import FrontLayout from '@/Layouts/frontLayout.vue';
export default { layout: FrontLayout }
</script>