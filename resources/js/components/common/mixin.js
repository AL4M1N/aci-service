import axios from "axios";
import createUpdate from './crud'


export default {
    data() {
        return {

            paginate_custom: 10,
            currentPageNumber: null,

            allData: {},
            totalValue: "",

            dataModalDialog: false,
            dataModalLoading: false,
            v_total: null,

            editmode: false,
            dataModal: false,
            dataLodaing: false,
            dataModelTitle: "",
            dataLoading: false,
        }
    },

    methods: {
        ...createUpdate,
    },



}
