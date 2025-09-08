## Класс Helpers обетка с полезными функциями.

```javascript
class Helpers {
    static delegateEvent(root, eventName, selector, handler){
        root.addEventListener(eventName, function(e){
            let el = e.target.closest(selector);

            if(el !==null && root.contains(el)){
                handler.call(el, e);
            }
        });
    }
}
```


