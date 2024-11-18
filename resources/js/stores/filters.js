import { defineStore } from "pinia";

export const useFilterStore = defineStore("filters", {
    state: () => ({
        investmentType: "all",
        startDate: "",
        endDate: "",
    }),
    actions: {
        setFilters(filters) {
            this.investmentType = filters.investmentType;
            this.startDate = filters.startDate;
            this.endDate = filters.endDate;
        },
    },
});
