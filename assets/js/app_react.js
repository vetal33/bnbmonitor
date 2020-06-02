import React, {Component} from 'react';
import ReactDom from 'react-dom';


import RepLogApp from './RepLog/RepLogApp';
//import SimpleLineChart from "./Chart/ChartApp";

//const el = React.createElement('h2', null, 'Lift History!', React.createElement('span', null, '❤'));

const el = <h2>Lift Stuff! <span>❤</span></h2>;

/*
const data = [
    {name: 'Page A', uv: 4000, amt: 2400},
    {name: 'Page B', uv: 3000, amt: 2210},
    {name: 'Page C', uv: 2000, amt: 2290},
    {name: 'Page D', uv: 2780, amt: 2000},
    {name: 'Page E', uv: 1890, amt: 2181},
    {name: 'Page F', uv: 2390, amt: 2500},
    {name: 'Page G', uv: 3490, amt: 2100},
];
*/

/*class SimpleLineChart extends Component {
    render() {
        return (
            <LineChart width={750} height={400} data={data}
                       margin={{top: 5, right: 30, left: 20, bottom: 5}}>
                <XAxis dataKey="name"/>
                <YAxis/>
                <CartesianGrid strokeDasharray="3 3"/>
                <Tooltip/>
                <Legend/>
                <Line type="monotone" dataKey="pv" stroke="#8884d8" activeDot={{r: 8}}/>
                <Line type="monotone" dataKey="uv" stroke="#82ca9d"/>
            </LineChart>
        );
    }
}*/

/*ReactDom.render(
    <SimpleLineChart/>,
    document.getElementById('container-chart')
);*/


ReactDom.render(
    <RepLogApp/>,
    document.getElementById('table-currency')
);