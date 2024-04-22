import{c as f,d as g,u as v,e as C,j as e,i as D,D as h,f as j,s as N,S as y,P as p,g as k,h as w,r as c,k as x,l as I,M as P,X as S,R as z,a as u}from"./index-DP0cNXZT.js";const E=()=>({name:f().required("El campo de nombre es obligatorio").min(8,"El nombre debe contener al menos 8 caracteres").max(200,"El nombre debe contener 200 caracteres como máximo")}),b=({hasEditon:n=!1,title:i="Crea una dimensión para agrupar tus pregustas",callback:o})=>{const{loading:l,dimension:t,startCreateDimension:m,startUpdateDimension:d}=g(),s=v({initialValues:{name:t!=null&&t.name&&n?t.name:""},validationSchema:C(E()),onSubmit:a=>{n?d(t.id,a,o):m(a)}});return e.jsxs("div",{className:"col-span-2",children:[e.jsx("h2",{className:`bg-gradient-to-r from-primary to-emerald-600 inline-block text-transparent bg-clip-text text-base font-bold ${!n&&"mt-40"}`,children:i}),e.jsxs("form",{onSubmit:s.handleSubmit,children:[e.jsx(D,{placeholder:"Nombre de la dimensión",className:"my-5 text-emerald-600",size:"md",name:"name",value:s.values.name,startContent:e.jsx(h,{strokeWidth:1.8}),isInvalid:!!(s.touched.name&&s.errors.name),errorMessage:s.touched.name&&s.errors.name&&s.errors.name,onChange:s.handleChange}),e.jsx(j,{className:"w-full mt-5 bg-slate-800 py-7 text-white font-bold text-xs",isLoading:l,spinner:e.jsx(N,{size:"sm",color:"current"}),startContent:e.jsx("span",{className:"w-[1.5rem] h-[1.5rem] bg-white text-black rounded-full flex justify-center items-center",children:e.jsx(y,{strokeWidth:1.5,height:22,width:22})}),size:"lg",type:"submit",children:n?"Actualizar":"Crear"})]})]})},R=()=>e.jsx(p,{title:"Crear dimensión",children:e.jsxs("div",{className:"grid grid-cols-1 lg:grid-cols-3 gap-x-10 mt-20",children:[e.jsx(b,{}),e.jsx("div",{className:"lg:flex justify-center hidden",children:e.jsx("img",{src:"/cuestionario/public/assets/form.svg",alt:"form-icon",width:600,height:300})})]})}),O=()=>{const{navigate:n}=k(),{dimensions:i,loading:o,startGetDimensions:l,startGetCurrentDimension:t}=g(),{isOpen:m,onOpen:d,onOpenChange:s}=w();c.useEffect(()=>{l()},[]);const a=r=>{d(),t(r.id)};return e.jsxs(p,{title:"Dimensiones",children:[e.jsx("div",{className:"grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-2 xl:gap-5 my-4 lg:mt-20",children:e.jsx(x,{data:i,loading:o,onPress:a,children:e.jsx(x.CreateItem,{title:"Crear dimension",image:e.jsx(I,{}),onPress:()=>n("create")})})}),e.jsx(P,{isOpen:m,onChange:s,hideCloseButton:!0,size:"4xl",renderContent:r=>e.jsxs(c.Fragment,{children:[e.jsxs("header",{className:"flex items-center justify-between -mt-6 py-1 border-b-2 ",children:[e.jsxs("div",{className:"flex items-center font-bold [&>svg]:text-emerald-600 text-xl [&>svg]:mr-1 pt-4 [&>svg]:border-2 [&>svg]:rounded-full [&>svg]:p-1",children:[e.jsx(h,{width:35,height:35,strokeWidth:1.5}),e.jsx("h3",{children:"Detalle de Dimension"})]}),e.jsx(j,{isIconOnly:!0,className:"border-2 bg-transparent",onClick:()=>{r()},children:e.jsx(S,{})})]}),e.jsx(b,{hasEditon:!0,title:"Edita el nombre de la dimensión",callback:r})]})})]})},L=()=>e.jsxs(z,{children:[e.jsx(u,{path:"/",index:!0,element:e.jsx(O,{})}),e.jsx(u,{path:"/create",element:e.jsx(R,{})})]});export{L as default};