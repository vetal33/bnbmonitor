import React, {Component} from "react";
import {LineChart, Line, XAxis, YAxis, CartesianGrid, Tooltip, Legend,} from 'recharts';
import ChartList from "./ChartList";
import {getLastFlow} from "../api/get_all";
import RepLogs from "../RepLog/RepLogs";

export default class SimpleLineChart extends Component {
    constructor(props) {
        super(props);
/*        getLastFlow()
            .then((data) => {
                console.log(data);
            });*/

        this.state = {
            highlightedRowId: null,
            data: [
                {name: 'Page A', uv: 4000, amt: 2400},
                {name: 'Page B', uv: 3000, amt: 2210},
                {name: 'Page C', uv: 2000, amt: 2290},
                {name: 'Page D', uv: 2780, amt: 2000},
                {name: 'Page E', uv: 1890, amt: 2181},
                {name: 'Page F', uv: 2390, amt: 2500},
                {name: 'Page G', uv: 3490, amt: 2100},
            ],
            isLoaded: false,
        };

    }

    render() {
        const {data} = this.state;

        return <ChartList
            data={data}
        />
    }
}