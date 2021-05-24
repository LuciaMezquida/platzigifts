import { registerBlockType } from "@wordpress/blocks";
import { TextControl } from "@wordpress/components";

registerBlockType("pg/basic", {
  title: "Basic Block",
  description: "Nuestro primer bloque.",
  icon: "smiley", //de la librería dash_icon
  category: "layout",
  // keywords: ["wordpress", "gutenberg", "platzigift"],
  attributes: {
    content: {
      type: "string",
      default: "Hello Muka",
    },
  },
  edit: (props) => {
    const {
      attributes: { content },
      setAttributes,
      className,
    } = props;
    const handlerOnChangeInput = (newContent) => {
      //el componente va a trabajar con el contenido
      setAttributes({ content: newContent });
    };
    return (
      <>
        {/* <InspectorControls>
          <PanelBody
            title="Modificar texto del Bloque Básico"
            initialOpen={false}
          >
            <PanelRow> */}
        <TextControl
          label="Complete el campo"
          value={content}
          onChange={handlerOnChangeInput}
        />
        {/* </PanelRow>
          </PanelBody>
        </InspectorControls>
        <h2>{content}</h2> */}
      </>
    );
  },
  save: (props) => <h2>{props.attributes.content}</h2>,
});
