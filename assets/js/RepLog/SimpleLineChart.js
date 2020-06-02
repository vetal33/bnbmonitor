import React from 'react';
import PropTypes from 'prop-types';
import {BarChart, CartesianGrid, Legend, Line, LabelList, LineChart, Bar, Tooltip, XAxis, YAxis} from "recharts";

export default function SimpleLineChart(props) {
    const {data, coinName} = props;
    return (
        <div>
            <div>
                <h4>{coinName} rate</h4>
                <LineChart width={750} height={400} data={data}
                           margin={{top: 5, right: 30, left: 20, bottom: 5}}>
                    <CartesianGrid strokeDasharray="3 3" />
                    <XAxis dataKey="name"/>
                    <YAxis domain={['auto', 'auto']}/>
                    <Tooltip/>
                    <Line type="monotone" dataKey="price" stroke="#8884d8" activeDot={{r: 5}}>
                       {/* <LabelList dataKey="price" position="top" />*/}
                    </Line>
                </LineChart >
            </div>
            <div>
                <BarChart width={750} height={200} data={data}
                           margin={{top: 5, right: 30, left: 20, bottom: 5}}>
                    <CartesianGrid stroke='#f5f5f5'/>
                    <XAxis dataKey="name"/>
                    <YAxis/>
                    <Tooltip/>
                    <Bar dataKey='volume' barSize={20} fill='#413ea0' />
                </BarChart  >
            </div>
        </div>


    );
}
SimpleLineChart.propTypes = {
    data: PropTypes.array.isRequired,
    coinName: PropTypes.string,
};
