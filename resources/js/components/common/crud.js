export default {

    getResults(page = 1) {
        this.dataLoading = true;
        return axios.get(this.currentUrl + '/index?page=', {
            params: {
                page: page,
                paginate: this.paginate_custom,
            }
        }).then(response => {
            this.allData = response.data;
            this.totalValue = response.data.total;
            this.currentPageNumber = response.data.current_page
            this.v_total = response.data.last_page;
            this.dataLoading = false;
        });
    },


    createData() {
        this.dataLodaing = true
        this.form.post(this.currentUrl + '/store').then(response => {
            this.resetForm();
            this.dataModal = false;
            this.dataLodaing = false;

            this.getResults(this.currentPageNumber);

            Toast.fire({
                icon: response.data.icon,
                title: response.data.msg
            });

        }).catch(error => {
            if (error.response.data.msg) {
                this.dataLodaing = false;
                Swal.fire("Failed!", error.response.data.msg, "warning");
            } else {
                this.dataLodaing = false;
                console.log(error.response.data);
                Swal.fire({
                    icon: 'error',
                    title: 'Failed!' + '<br>' + error.response.data.message,
                    customClass: 'text-danger'
                });
            }

        });
    },


    resetForm() {
        this.form.reset();
        this.form.errors.clear();
    },

    uploadImageByName: function (event, currentFieldName, acceptType = ['jpg', 'png', 'jpeg']) {
        let file = event.target.files[0];

        if (!file) {
            this.form.errors[currentFieldName] = 'No file selected';
            return;
        }

        let fileExt = file.name.split('.').pop().toLowerCase();
        let matchFound = acceptType.includes(fileExt);

        if (!matchFound) {
            let errMessage = 'Accept only ' + acceptType.join(", ") + '.';
            alert('File type not accepted: ' + fileExt);
            this.form.errors[currentFieldName] = errMessage;
            return;
        }

        if (file.size > this.imageMaxSize) {
            let imageMaxSizeInMB = Math.round(this.imageMaxSize / 1000000);
            let errMessage = `File size can not be bigger than ${imageMaxSizeInMB} MB`;
            alert(errMessage);
            this.form.errors[currentFieldName] = errMessage;
            return;
        }

        // Store the actual File object, not the Data URL
        this.form[currentFieldName] = file;
        this.form.errors[currentFieldName] = null;

        // Optional: Create preview (but don't replace the file)
        let reader = new FileReader();
        reader.onloadend = () => {
            this.imagePreview = reader.result; // Store preview separately
        };
        reader.readAsDataURL(file);
    },

    showImageByName(currentFieldName) {
        // If no image is selected
        if (!this.form[currentFieldName]) {
            return "/all-assets/common/img/no-image.png";
        }

        // Case 1: It's a File object (new upload)
        if (this.form[currentFieldName] instanceof File) {
            return URL.createObjectURL(this.form[currentFieldName]);
        }

        // Case 2: It's a base64 string (if you still use this somewhere)
        if (typeof this.form[currentFieldName] === 'string' && this.form[currentFieldName].length > 100) {
            return this.form[currentFieldName];
        }

        // Case 3: It's a stored filename (from database)
        return this.imagePathSm + this.form[currentFieldName];
    }

}
