import React, {Component} from "react";
import RepLogs from './RepLogs';
import SimpleLineChart from './SimpleLineChart';

import {getRepLogs, getLastFlow} from '../api/get_all';

export default class RepLogApp extends Component {
    constructor(props) {
        super(props);

        this.state = {
            highlightedRowId: null,
            repLogs: [],
            isLoaded: false,
            data: [],
            coinName: '',
        };

        this.handleRowClick = this.handleRowClick.bind(this);
    }

    getCoinName(data) {
        this.setState({
            coinName: data.coin.name,
        })
    }

    componentDidMount() {
        getRepLogs()
            .then((data) => {
                this.setState({
                    repLogs: data,
                    isLoaded: true
                });
            });
    }

    handleRowClick(repLogId) {
        getLastFlow(repLogId)
            .then((data) => {
                this.setState({
                    data: data.reverse().map(dataOne => {
                        return {
                            'name': dataOne.timeInStr,
                            'volume': dataOne.volume,
                            'price': dataOne.price,
                        }
                    })
                });
                this.getCoinName(data);
            });
        this.setState({
            highlightedRowId: repLogId,
        });
    }

    render() {
        return (
            <div className="row">
                <div className="col-7">
                    <SimpleLineChart
                        {...this.props}
                        {...this.state}
                    />
                </div>
                <div className="col-5">
                    <RepLogs
                        {...this.props}
                        {...this.state}
                        onRowClick={this.handleRowClick}
                    />
                </div>
            </div>
        )
    }
}