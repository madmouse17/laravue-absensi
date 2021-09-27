<template>
    <Menubar />
    <center>
        <Card
            style="width: 25rem; margin-bottom: 2em"
            class="p-m-0 p-d-flex p-jc-center"
        >
            <template #title> Silahkan Presensi Disini </template>
            <template #content>
                <video
                    id="inputVideo"
                    ref="inputVideo"
                    width="400"
                    height="400"
                    class="p-mr-2"
                    autoplay
                    muted
                ></video>
                <canvas id="overlay" ref="Overlay" />
            </template>
        </Card>
    </center>
</template>
<script>
import * as faceapi from "face-api.js";
import Menubar from "@/Layouts/Guest/Menubar";
import Card from "primevue/card";
export default {
    components: {
        Menubar,
        Card,
    },
    props: ["image"],
    data() {
        return {
            form: this.$inertia.form({
                image: null,
            }),
        };
    },
    video: $("#inputVideo").get(0),
    mounted() {
        Promise.all([
            faceapi.nets.tinyFaceDetector.loadFromUri("/js/weights/"),
            faceapi.nets.faceLandmark68Net.loadFromUri("/js/weights/"),
            faceapi.nets.faceRecognitionNet.loadFromUri("/js/weights/"),
            faceapi.nets.ssdMobilenetv1.loadFromUri("/js/weights/"),
        ]).then(this.startVideo),
            this.video.addEventListener("play", () => {
                const displaySize = {
                    width: this.video.width,
                    height: this.video.height,
                };
                faceapi.matchDimensions(this.canvas, displaySize);

                setInterval(async () => {
                    const detections = await faceapi
                        .detectAllFaces(
                            this.video,
                            new faceapi.TinyFaceDetectorOptions()
                        )
                        .withFaceLandmarks()
                        .withFaceDescriptors();
                    const resizedDetections = faceapi.resizeResults(
                        detections,
                        displaySize
                    );
                    this.canvas
                        .getContext("2d")
                        .clearRect(0, 0, this.canvas.width, this.canvas.height);

                    const labeledFaceDescriptors =
                        await this.loadLabeledImages();
                    const faceMatcher = new faceapi.FaceMatcher(
                        labeledFaceDescriptors,
                        0.6
                    );
                    const results = resizedDetections.map((d) =>
                        faceMatcher.findBestMatch(d.descriptor)
                    );
                    results.forEach((result, i) => {
                        const box = resizedDetections[i].detection.box;
                        const drawBox = new faceapi.draw.DrawBox(box, {
                            label: result.toString(),
                        });
                        drawBox.draw(this.canvas);
                        if (result._label != "unknown") {
                            this.form.image = result._label;
                            this.form.get(
                                this.route("presensi.create"),
                                this.form.image,
                                {
                                    preserveState: true,
                                    replace: true,
                                }
                            );
                        }
                    });
                }, 100);
            });
    },
    methods: {
        startVideo() {
            navigator.getUserMedia(
                { video: {} },
                (stream) => (this.video.srcObject = stream),
                (err) => console.error(err)
            );
        },
        loadLabeledImages() {
            // const labels = ["galih", "aji"];
            return Promise.all(
                this.image.map(async (label) => {
                    const descriptions = [];
                    // for (let i = 1; i <= 2; i++) {
                    const img = await faceapi.fetchImage(
                        `https://laravue.test/storage/pegawai/${label}`
                    );
                    const detections = await faceapi
                        .detectSingleFace(img)
                        .withFaceLandmarks()
                        .withFaceDescriptor();
                    descriptions.push(detections.descriptor);
                    // }

                    return new faceapi.LabeledFaceDescriptors(
                        label,
                        descriptions
                    );
                })
            );
        },
    },
    computed: {
        video() {
            return this.$refs.inputVideo;
        },
        canvas() {
            return this.$refs.Overlay;
        },
    },
};
</script>
