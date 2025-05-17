<template>
  <div>
    <v-card>
      <v-card-title class="justify-center">
        <v-row align="center">
          <v-col cols="10">Service List </v-col>
          <v-col cols="2">
            <v-btn
              icon="mdi-plus-box"
              variant="text"
              title="Add"
              class="float-right btn_add_color"
              size="x-large"
              @click="dataModal = true"
            ></v-btn>
          </v-col>
        </v-row>
      </v-card-title>

      <v-card-text>
        <div>
          <div class="table-responsive" v-if="allData && allData.data">
            <v-table class="table table-bordered">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Customer</th>
                  <th>Phone</th>
                  <th>Chasis</th>
                  <th>KM Run</th>
                  <th>Bay Number</th>
                  <th>Service Charge</th>
                  <th>Service Type</th>
                  <th>Service Date</th>
                  <th>Service Time</th>
                  <th>End Time</th>
                  <th>Image</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="singleData in allData.data" :key="singleData.id">
                  <td>{{ singleData.id }}</td>
                  <td>{{ singleData.customer }}</td>
                  <td>{{ singleData.phone }}</td>
                  <td>{{ singleData.chasis }}</td>
                  <td>{{ singleData.km }}</td>
                  <td>{{ singleData.bay }}</td>
                  <td>{{ singleData.charge }}</td>
                  <td>{{ singleData.type }}</td>
                  <td>{{ singleData.date }}</td>
                  <td>{{ singleData.time }}</td>
                  <td>{{ singleData.end_time }}</td>
                  <td>
                    <img
                      width="50"
                      :src="'../storage/app/images/service/' + singleData.image"
                    />
                  </td>
                  <td>
                    <v-btn
                      icon="mdi-check-circle"
                      variant="text"
                      color="success"
                      title="Mark as Done"
                      @click="openDoneModal(singleData)"
                    ></v-btn>

                    <v-btn
                      icon
                      variant="text"
                      class="btn_edit_color"
                      title="Update Data"
                      size="medium"
                      @click="editMonthData(singleData)"
                    ></v-btn>
                  </td>
                </tr>
              </tbody>
            </v-table>
          </div>

          <v-pagination
            v-if="v_total > 1"
            v-model="currentPageNumber"
            :length="v_total"
            :total-visible="7"
            @update:modelValue="getResults"
            rounded="circle"
            size="small"
            active-color="red"
            color="green"
          ></v-pagination>
        </div>
        <div v-if="!totalValue && !dataLoading">
          <h6 class="text-info text-center">No Data</h6>
        </div>
      </v-card-text>
    </v-card>

    <!-- data modal start -->
    <v-dialog v-model="dataModal" width="900" persistent>
      <v-card>
        <v-card-title class="justify-center">
          <v-row align="center">
            <v-col cols="10">Add Service</v-col>
            <v-col cols="2">
              <v-btn
                @click="(dataModal = false), resetForm()"
                icon
                title="Close"
                class="float-right"
                variant="text"
              >
                <v-icon
                  icon="mdi-close-circle-outline"
                  color="red"
                  size="x-large"
                ></v-icon>
              </v-btn>
            </v-col>
          </v-row>
        </v-card-title>

        <v-card-text>
          <v-container>
            <v-form @submit.prevent="createData()">
              <v-row>
                <v-col cols="12" sm="12" lg="12" md="12">
                  <v-text-field
                    variant="outlined"
                    density="compact"
                    v-model="form.customer"
                    label="Customer Name"
                    placeholder="Enter Customer Name"
                    :error-messages="form.errors.get('customer')"
                    class="required"
                  ></v-text-field>
                </v-col>

                <v-col cols="12" sm="12" lg="12" md="12">
                  <v-text-field
                    variant="outlined"
                    density="compact"
                    v-model="form.phone"
                    label="Customer Phone Number"
                    placeholder="Enter Phone Number"
                    :error-messages="form.errors.get('phone')"
                    class="required"
                  ></v-text-field>
                </v-col>

                <v-col cols="12" sm="12" lg="12" md="12">
                  <v-text-field
                    variant="outlined"
                    density="compact"
                    v-model="form.chasis"
                    label="Bike Chasis Number"
                    placeholder="Bike Chasis Number"
                    :error-messages="form.errors.get('chasis')"
                    class="required"
                  ></v-text-field>
                </v-col>

                <v-col cols="12" sm="12" lg="12" md="12">
                  <v-text-field
                    variant="outlined"
                    density="compact"
                    v-model="form.km"
                    label="Bike KM Run"
                    placeholder="Bike KM Run"
                    :error-messages="form.errors.get('km')"
                    class="required"
                  ></v-text-field>
                </v-col>

                <v-col cols="12" sm="12" lg="12" md="12">
                  <v-text-field
                    variant="outlined"
                    density="compact"
                    v-model="form.bay"
                    label="Service Bay"
                    placeholder="Write Service Bay Number"
                    :error-messages="form.errors.get('bay')"
                    class="required"
                  ></v-text-field>
                </v-col>

                <v-col cols="12" sm="12" lg="12" md="12">
                  <v-text-field
                    variant="outlined"
                    density="compact"
                    v-model="form.charge"
                    label="Service charge"
                    placeholder="Write Service charge"
                    :error-messages="form.errors.get('charge')"
                    class="required"
                  ></v-text-field>
                </v-col>

                <v-col cols="12" sm="12" lg="12" md="12">
                  <v-autocomplete
                    label="Autocomplete"
                    :items="['Free', 'Paid']"
                    variant="outlined"
                    density="compact"
                    v-model="form.type"
                    placeholder="Select Service Type"
                    :error-messages="form.errors.get('type')"
                    class="required"
                  ></v-autocomplete>
                </v-col>

                <v-col cols="12" md="6">
                  <p>Service Date</p>
                  <!-- <VueDatePicker
                    v-model="form.date"
                    :enable-time-picker="false"
                    auto-apply
                    :format="format"
                    variant="solo-filled"
                    placeholder="Select Date"
                    density="comfortable"
                    class="datepicker"
                    :teleport="true"
                  ></VueDatePicker> -->
                  <input type="date" class="form-control" v-model="form.date" />
                  <!-- <div
                    class="text-danger"
                    v-if="form.errors.has('date')"
                    v-html="form.errors.get('date')"
                  ></div> -->
                </v-col>

                <v-col cols="6" md="6">
                  <p>Serive Time</p>
                  <!-- <VueDatePicker
                    v-model="form.time"
                    time-picker
                    auto-apply
                    disable-time-range-validation
                    placeholder="Select Time"
                    variant="solo-filled"
                    density="comfortable"
                    class="datepicker"
                    :teleport="true"
                  ></VueDatePicker> -->
                  <input type="time" class="form-control" v-model="form.time" />
                  <div
                    class="text-danger"
                    v-if="form.errors.has('time')"
                    v-html="form.errors.get('time')"
                  ></div>
                </v-col>

                <v-col cols="8">
                  <v-file-input
                    variant="outlined"
                    density="compact"
                    hint="Dimention:300x200px"
                    persistent-hint
                    show-size
                    truncate-length="15"
                    small-chips
                    prepend-icon="mdi-camera"
                    @change="
                      uploadImageByName($event, 'image', ['jpg', 'png', 'jpeg'])
                    "
                    label="Choose bike Image"
                    accept=".jpg, .png, .jpeg"
                    :error-messages="form.errors.get('image')"
                    class="required"
                  ></v-file-input>
                </v-col>
                <v-col cols="4">
                  <img
                    :src="showImageByName('image')"
                    class="rounded mx-auto d-block image-thum-size"
                    style="width: 100%"
                  />
                </v-col>

                <v-col
                  cols="12"
                  v-for="(part, index) in form.parts"
                  :key="index"
                >
                  <v-row>
                    <v-col cols="5">
                      <v-autocomplete
                        v-model="part.type"
                        :items="availableParts"
                        item-title="name"
                        item-value="code"
                        label="Parts"
                        variant="outlined"
                        density="compact"
                      ></v-autocomplete>
                    </v-col>
                    <v-col cols="5">
                      <v-text-field
                        v-model="part.amount"
                        label="Quantity"
                        variant="outlined"
                        density="compact"
                        type="number"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="2">
                      <v-btn @click="removePart(index)" text color="error">
                        Remove
                      </v-btn>
                    </v-col>
                  </v-row>
                </v-col>

                <v-row>
                  <v-col cols="12" class="text-center">
                    <v-btn @click="addPart" text variant="outlined" color="info"
                      >Add Part</v-btn
                    >
                  </v-col>
                </v-row>

                <v-col cols="12">
                  <v-btn
                    type="submit"
                    block
                    class="my-2 btn_save"
                    :loading="dataLodaing"
                    ><v-icon start icon="mdi-plus-box"></v-icon>Create
                  </v-btn>
                </v-col>
              </v-row>
            </v-form>
          </v-container>
        </v-card-text>
      </v-card>
    </v-dialog>

    <v-dialog v-model="doneModal" width="500" persistent>
      <v-card>
        <v-card-title class="justify-center">
          <v-row align="center">
            <v-col cols="10">Complete Service</v-col>
            <v-col cols="2">
              <v-btn
                @click="doneModal = false"
                icon
                title="Close"
                class="float-right"
                variant="text"
              >
                <v-icon
                  icon="mdi-close-circle-outline"
                  color="red"
                  size="x-large"
                ></v-icon>
              </v-btn>
            </v-col>
          </v-row>
        </v-card-title>

        <v-card-text>
          <v-form @submit.prevent="markAsDone">
            <v-row>
              <v-col cols="12">
                <VueDatePicker
                  v-model="completeForm.end_time"
                  time-picker
                  auto-apply
                  placeholder="Select completion time"
                  variant="solo-filled"
                  density="comfortable"
                  :teleport="true"
                ></VueDatePicker>
              </v-col>

              <v-col cols="12">
                <v-btn
                  type="submit"
                  block
                  class="my-2 btn_save"
                  :loading="completeForm.busy"
                >
                  <v-icon start icon="mdi-check-circle"></v-icon>
                  Mark as Done
                </v-btn>
              </v-col>
            </v-row>
          </v-form>
        </v-card-text>
      </v-card>
    </v-dialog>
  </div>
</template>

  <script>
import Form from "vform";
export default {
  data() {
    return {
      currentUrl: "service",
      dbParts: [],
      imageUrl: "/images/service/",
      doneModal: false,

      doneModal: false,
      currentServiceId: null,
      completeForm: new Form({
        end_time: "",
      }),

      form: new Form({
        id: "",
        customer: "",
        phone: "",
        chasis: "",
        km: "",
        bay: "",
        charge: "",
        type: "",
        date: "",
        time: "",
        image: "",
        parts: [],
      }),
    };
  },

  methods: {
    addPart() {
      this.form.parts.push({ type: null, amount: null });
    },
    removePart(index) {
      this.form.parts.splice(index, 1);
    },
    getParts() {
      axios.get("/service/all_parts").then((response) => {
        this.dbParts = response.data;
      });
    },

    openDoneModal(service) {
      this.currentServiceId = service.id;
      this.doneModal = true;
    },

    markAsDone() {
      this.completeForm
        .post(`/${this.currentUrl}/${this.currentServiceId}/complete`)
        .then((response) => {
          this.doneModal = false;
          this.getResults(); // Refresh the list
          Toast.fire({
            icon: "success",
            title: response.data.msg || "Service marked as completed",
          });
        })
        .catch((error) => {
          if (error.response.data.msg) {
            Swal.fire("Failed!", error.response.data.msg, "warning");
          } else {
            console.error(error);
          }
        });
    },
  },

  async mounted() {
    await this.getResults();
    await this.getParts();
  },

  computed: {
    availableParts() {
      const existingParts = this.form.parts.map((part) => part.type);
      return this.dbParts.filter((part) => !existingParts.includes(part.name));
    },
  },
};
</script>

  <style scoped>
</style>
