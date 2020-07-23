import React from 'react';
import RepLogList from './RepLogList';
import PropTypes from 'prop-types';

/*function calculateTotalWeightLifted(repLogs) {
    let total = 0;
    for (let repLog of repLogs) {
        total += repLog.price;
    }
    return total;
}*/

export default function RepLogs(props) {
    const {
        highlightedRowId,
        onRowClick,
        repLogs,
        isLoaded
    } = props;
    //const calculateTotalWeightFancier = repLogs => repLogs.reduce((total, log) => total + log.price, 0);
    return (
        <div className="currency-table">
            <div>List of currencies</div>
            <table className="table table-sm">
                <thead>
                <tr>
                    <th>ShortName</th>
                    <th>Name </th>
                </tr>
                </thead>
                <RepLogList
                    highlightedRowId={highlightedRowId}
                    onRowClick={onRowClick}
                    repLogs={repLogs}
                    isLoaded = {isLoaded}
                />
            </table>
        </div>
    )
}
RepLogs.propTypes = {
    highlightedRowId: PropTypes.any,
    onRowClick: PropTypes.func.isRequired,
    repLogs: PropTypes.array.isRequired,
    isLoaded: PropTypes.bool.isRequired,
};
