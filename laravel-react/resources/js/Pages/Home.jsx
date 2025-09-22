import React from 'react';
import '../../css/app.css';
import '../../css/style.css';

export default function Home({ exampleProp, anotherProp }) {
    return (
        <div>
            <h1 id="color">hello user</h1>
            <p id='color'>{exampleProp}</p>
            <p>Another Prop: {anotherProp}</p>
        </div>
    );
}
