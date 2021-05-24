import { registerBlockType } from "@wordpress/blocks";

registerBlockType("pg/basic", {
  title: "Basic Block",
  description: "Nuestro primer bloque.",
  icon: "smiley", //de la librería dash_icon
  category: "layout",
  // keywords: ["wordpress", "gutenberg", "platzigift"],
  // attributes: {
  //   content: {
  //     type: "string",
  //     default: "Hello world",
  //   },
  // },
  // edit: (props) => {
  //   const {
  //     attributes: { content },
  //     setAttributes,
  //     className,
  //   } = props;
  //   const handlerOnChangeTextControl = (newContent) => {
  //     setAttributes({ content: newContent });
  //   };
  //   return (
  //     <>
  //       <InspectorControls>
  //         <PanelBody
  //           title="Modificar texto del Bloque Básico"
  //           initialOpen={false}
  //         >
  //           <PanelRow>
  //             <TextControl
  //               label="Complete el campo"
  //               value={content}
  //               onChange={handlerOnChangeTextControl}
  //             />
  //           </PanelRow>
  //         </PanelBody>
  //       </InspectorControls>
  //       <h2>{content}</h2>
  //     </>
  //   );
  // },
  edit: () => <h2>Hello Muka</h2>,
  save: () => <h2>Hello Muka</h2>,
});
