import React from 'react';
import PropTypes from 'prop-types';

export default function RepLogList(props) {

    const {
        highlightedRowId,
        onRowClick,
        repLogs,
        isLoaded
    } = props;

    if (!isLoaded) {
        return (
            <tbody>
            <tr>
                <td colSpan="4" className="text-center">Loading...</td>
            </tr>
            </tbody>
        )
    }

    return (
        <tbody>
        {repLogs.map((repLog) => (
            <tr
                key={repLog.id}
                className={highlightedRowId === repLog.id ? 'info' : ''}
                onClick={() => onRowClick(repLog.id)}
            >
                <td>{repLog.shortName}</td>
                <td>{repLog.name}</td>
            </tr>
        ))}
        </tbody>
    )
}
RepLogList.propTypes = {
    highlightedRowId: PropTypes.any,
    onRowClick: PropTypes.func.isRequired,
    repLogs: PropTypes.array.isRequired,
    isLoaded: PropTypes.bool.isRequired,
};