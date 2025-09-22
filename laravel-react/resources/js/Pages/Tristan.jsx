import '../../css/app.css';

export default function Tristan({ exampleProp, anotherProp }) {
    return (
        <div>
            <h1 id="color">hello user Tristan</h1>
            <p id='color'>{exampleProp}</p>
            <p>Another Prop: {anotherProp}</p>
        </div>
    );
}
