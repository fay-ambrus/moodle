define([], function() {
    return {
        refreshSearchCriteria: function(selectorType, columnName, selectedValue) {
            let searchCriteriaList = document.getElementById('active-search-criteria');
            let criteriaElement = document.getElementById(columnName);
            if (criteriaElement) {
                searchCriteriaList.removeChild(criteriaElement);
            }

            if (selectedValue) {
                let newCriteriaElement = document.createElement('li');
                newCriteriaElement.setAttribute('id', columnName);

                if (selectorType === 'selectMultiple') {
                    newCriteriaElement.innerHTML = "Column " + columnName + " must contain " + selectedValue;

                } else if (selectorType === 'search') {
                    newCriteriaElement.innerHTML = "Column " + columnName + " must include " + selectedValue;
                }

                searchCriteriaList.appendChild(newCriteriaElement);
            }
        }
    }
});