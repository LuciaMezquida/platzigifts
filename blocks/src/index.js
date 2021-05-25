import { registerBlockType } from "@wordpress/blocks";
import { InspectorControls } from "@wordpress/editor";
import { TextControl, PanelBody, PanelRow } from "@wordpress/components";
import ServerSideRender from "@wordpress/server-side-render";

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
      isSelected,
    } = props;
    const handlerOnChangeInput = (newContent) => {
      //el componente va a trabajar con el contenido
      setAttributes({ content: newContent });
    };
    return (
      <>
        <InspectorControls>
          <PanelBody // Primer panel en la sidebar
            title="Modificar texto del Bloque Básico"
            initialOpen={false}
          >
            <PanelRow>
              <TextControl
                label="Complete el campo" // Indicaciones del campo
                value={content} // Asignación del atributo correspondiente
                onChange={handlerOnChangeInput} // Asignación de función para gestionar el evento OnChange
              />
            </PanelRow>
          </PanelBody>
        </InspectorControls>
        <ServerSideRender // Renderizado de bloque dinámico
          block="pg/basic" // Nombre del bloque
          attributes={props.attributes} // Se envían todos los atributos
        />
      </>
    );
  },
  save: () => null,
});
